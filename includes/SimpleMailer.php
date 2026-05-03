<?php
/**
 * SimpleMailer v2
 * Supports:
 *   - Port 465  SSL  (ssl://)  — Hostinger & most shared hosting
 *   - Port 587  STARTTLS       — localhost / most dev environments
 *
 * Zero dependencies. No Composer. Drop in and use.
 */
class SimpleMailer
{
    private string $host;
    private int    $port;
    private string $username;
    private string $password;
    private string $fromEmail;
    private string $fromName;
    private string $encryption; // 'ssl' or 'tls'

    /** @var resource|null */
    private $socket = null;
    private array $log = [];

    public string $lastError = '';

    public function __construct(
        string $host,
        int    $port,
        string $username,
        string $password,
        string $fromEmail,
        string $fromName  = '',
        string $encryption = 'tls'   // 'ssl' for port 465, 'tls' for port 587
    ) {
        $this->host       = $host;
        $this->port       = $port;
        $this->username   = $username;
        $this->password   = $password;
        $this->fromEmail  = $fromEmail;
        $this->fromName   = $fromName ?: $fromEmail;
        $this->encryption = strtolower($encryption);
    }

    /**
     * Send a multipart email.
     */
    public function send(
        string $toEmail,
        string $toName,
        string $replyTo,
        string $replyName,
        string $subject,
        string $htmlBody,
        string $textBody
    ): bool {
        try {
            if ($this->encryption === 'ssl') {
                $this->connectSSL();     // Immediate SSL wrap — port 465
            } else {
                $this->connectTLS();     // Plain connect then STARTTLS — port 587
            }

            $this->ehlo();
            $this->authenticate();
            $this->mailFrom();
            $this->rcptTo($toEmail);

            $boundary = 'bp_' . bin2hex(random_bytes(8));
            $this->data(
                $this->buildHeaders($toEmail, $toName, $replyTo, $replyName, $subject, $boundary) .
                $this->buildBody($htmlBody, $textBody, $boundary)
            );

            $this->quit();
            return true;

        } catch (\RuntimeException $e) {
            $this->lastError = $e->getMessage();
            error_log('[SimpleMailer] Error: ' . $e->getMessage());
            error_log('[SimpleMailer] SMTP log: ' . implode(' | ', $this->log));
            $this->close();
            return false;
        }
    }

    // ── Connection methods ────────────────────────────────────

    /** Port 465 — SSL from the start (Hostinger / shared hosting) */
    private function connectSSL(): void
    {
        $ctx = stream_context_create([
            'ssl' => [
                'verify_peer'       => true,
                'verify_peer_name'  => true,
                'allow_self_signed' => false,
            ],
        ]);

        $this->socket = stream_socket_client(
            "ssl://{$this->host}:{$this->port}",
            $errno,
            $errstr,
            15,
            STREAM_CLIENT_CONNECT,
            $ctx
        );

        if (!$this->socket) {
            throw new \RuntimeException("SSL connect failed [{$errno}]: {$errstr}");
        }

        stream_set_timeout($this->socket, 15);
        $this->expect(220, 'SSL connect greeting');
    }

    /** Port 587 — plain connect then STARTTLS upgrade */
    private function connectTLS(): void
    {
        $this->socket = fsockopen(
            'tcp://' . $this->host,
            $this->port,
            $errno,
            $errstr,
            15
        );

        if (!$this->socket) {
            throw new \RuntimeException("TCP connect failed [{$errno}]: {$errstr}");
        }

        stream_set_timeout($this->socket, 15);
        $this->expect(220, 'TCP connect greeting');

        // Upgrade to TLS
        $this->cmd('STARTTLS');
        $this->expect(220, 'STARTTLS');

        $ok = stream_socket_enable_crypto(
            $this->socket,
            true,
            STREAM_CRYPTO_METHOD_TLS_CLIENT
        );
        if (!$ok) {
            throw new \RuntimeException('STARTTLS crypto negotiation failed');
        }
    }

    // ── SMTP commands ─────────────────────────────────────────

    private function ehlo(): void
    {
        $this->cmd('EHLO ' . (gethostname() ?: 'localhost'));
        $this->expect(250, 'EHLO');
    }

    private function authenticate(): void
    {
        $this->cmd('AUTH LOGIN');
        $this->expect(334, 'AUTH LOGIN');

        $this->cmd(base64_encode($this->username));
        $this->expect(334, 'AUTH username');

        $this->cmd(base64_encode($this->password));
        $this->expect(235, 'AUTH password — check credentials if this fails');
    }

    private function mailFrom(): void
    {
        $this->cmd("MAIL FROM:<{$this->fromEmail}>");
        $this->expect(250, 'MAIL FROM');
    }

    private function rcptTo(string $to): void
    {
        $this->cmd("RCPT TO:<{$to}>");
        $this->expect(250, 'RCPT TO');
    }

    private function data(string $message): void
    {
        $this->cmd('DATA');
        $this->expect(354, 'DATA start');

        // RFC 2821 dot-stuffing
        $message = preg_replace('/^\./m', '..', $message);
        fwrite($this->socket, $message . "\r\n.\r\n");
        $this->log[] = '[DATA body sent]';
        $this->expect(250, 'DATA end — message accepted');
    }

    private function quit(): void
    {
        $this->cmd('QUIT');
        $this->close();
    }

    private function close(): void
    {
        if ($this->socket) {
            @fclose($this->socket);
            $this->socket = null;
        }
    }

    private function cmd(string $command): void
    {
        $this->log[] = '>> ' . $command;
        fwrite($this->socket, $command . "\r\n");
    }

    private function expect(int $code, string $context): string
    {
        $response = '';
        $deadline = time() + 15;

        while (time() < $deadline) {
            $line = fgets($this->socket, 1024);
            if ($line === false) {
                throw new \RuntimeException("No data from server during: {$context}");
            }
            $this->log[] = '<< ' . rtrim($line);
            $response   .= $line;

            // Final response line has a space after the 3-digit code
            if (isset($line[3]) && $line[3] === ' ') {
                break;
            }
        }

        $actual = (int) substr($response, 0, 3);
        if ($actual !== $code) {
            throw new \RuntimeException(
                "Expected {$code} during [{$context}], got {$actual}: " . trim($response)
            );
        }

        return $response;
    }

    // ── Email building ────────────────────────────────────────

    private function buildHeaders(
        string $toEmail, string $toName,
        string $replyTo, string $replyName,
        string $subject, string $boundary
    ): string {
        $date     = date('r');
        $msgId    = '<' . time() . '.' . bin2hex(random_bytes(4)) . '@portfolio>';
        $encFrom  = $this->mimeEncode($this->fromName);
        $encTo    = $this->mimeEncode($toName);
        $encSubj  = $this->mimeEncode($subject);
        $encReply = $this->mimeEncode($replyName);

        return implode("\r\n", [
            "Date: {$date}",
            "Message-ID: {$msgId}",
            "From: {$encFrom} <{$this->fromEmail}>",
            "To: {$encTo} <{$toEmail}>",
            "Reply-To: {$encReply} <{$replyTo}>",
            "Subject: {$encSubj}",
            "MIME-Version: 1.0",
            "Content-Type: multipart/alternative; boundary=\"{$boundary}\"",
            "X-Mailer: SimpleMailer/2.0",
            "",
        ]);
    }

    private function buildBody(string $html, string $text, string $boundary): string
    {
        return implode("\r\n", [
            "--{$boundary}",
            "Content-Type: text/plain; charset=UTF-8",
            "Content-Transfer-Encoding: base64",
            "",
            chunk_split(base64_encode($text)),
            "--{$boundary}",
            "Content-Type: text/html; charset=UTF-8",
            "Content-Transfer-Encoding: base64",
            "",
            chunk_split(base64_encode($html)),
            "--{$boundary}--",
        ]);
    }

    private function mimeEncode(string $value): string
    {
        if (preg_match('/[^\x20-\x7E]/', $value)) {
            return '=?UTF-8?B?' . base64_encode($value) . '?=';
        }
        return preg_match('/[",;<>]/', $value)
            ? '"' . addslashes($value) . '"'
            : $value;
    }
}
