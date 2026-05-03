<?php
// api/contact.php

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

// ── Only accept POST ──────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// ── Rate limiting — max 3 per IP per 10 min ───────────────
session_start();
$now    = time();
$window = 600;
$limit  = 3;
$_SESSION['contact_times'] = array_values(array_filter(
    $_SESSION['contact_times'] ?? [],
    fn($t) => ($now - $t) < $window
));
if (count($_SESSION['contact_times']) >= $limit) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'Too many requests. Please wait a few minutes before trying again.']);
    exit;
}

require_once __DIR__ . '/../includes/mail-config.php';
require_once __DIR__ . '/../includes/SimpleMailer.php';

// ── Honeypot — bots fill the hidden "website" field ──────
if (!empty($_POST['website'])) {
    echo json_encode(['success' => true, 'message' => "Message sent! I'll get back to you within 24 hours."]);
    exit;
}

// ── Validate input ────────────────────────────────────────
$name    = trim(strip_tags($_POST['name']    ?? ''));
$email   = trim(strip_tags($_POST['email']   ?? ''));
$subject = trim(strip_tags($_POST['subject'] ?? '')) ?: 'Portfolio Inquiry';
$message = trim(strip_tags($_POST['message'] ?? ''));

$errors = [];
if (strlen($name) < 2)                              $errors[] = 'Please enter your name.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL))     $errors[] = 'Please enter a valid email address.';
if (strlen($message) < 10)                          $errors[] = 'Message must be at least 10 characters.';
if (strlen($name) > 100)                            $errors[] = 'Name is too long.';
if (strlen($message) > 5000)                        $errors[] = 'Message is too long (max 5000 characters).';

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// ── Send email ────────────────────────────────────────────
$mailer = new SimpleMailer(
    SMTP_HOST,
    SMTP_PORT,
    SMTP_USERNAME,
    SMTP_PASSWORD,
    SMTP_FROM,
    SMTP_FROM_NAME,
    SMTP_ENCRYPTION   // 'ssl' on Hostinger, 'tls' on localhost
);

$ok = $mailer->send(
    toEmail:   MAIL_TO,
    toName:    'Chate Billy Chilima',
    replyTo:   $email,
    replyName: $name,
    subject:   '[Portfolio] ' . $subject,
    htmlBody:  buildHtml($name, $email, $subject, $message),
    textBody:  buildText($name, $email, $subject, $message)
);

if ($ok) {
    $_SESSION['contact_times'][] = $now;
    echo json_encode(['success' => true, 'message' => "Message sent! I'll get back to you within 24 hours."]);
} else {
    error_log('[contact.php] Send failed: ' . $mailer->lastError);
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Message could not be sent. Please email me directly at chatebchilima20@gmail.com'
    ]);
}

// ── Email templates ───────────────────────────────────────
function buildHtml(string $name, string $email, string $subject, string $message): string {
    $safe = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));
    $date = date('D, d M Y \a\t H:i T');
    return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#0d1117;font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#0d1117;padding:40px 20px;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="background:#161b22;border:1px solid #21293a;border-radius:12px;overflow:hidden;max-width:600px;width:100%;">

  <!-- Header -->
  <tr>
    <td style="background:#0d1117;padding:24px 32px;border-bottom:1px solid #21293a;">
      <span style="font-size:20px;font-weight:800;color:#00ff88;font-family:'Courier New',monospace;">&#9889; Portfolio Contact</span>
      <span style="display:block;font-size:11px;color:#6e7681;font-family:'Courier New',monospace;margin-top:3px;">// new message received</span>
    </td>
  </tr>

  <!-- Sender info -->
  <tr>
    <td style="padding:28px 32px 0;">
      <table width="100%" cellpadding="0" cellspacing="0" style="background:#0d1117;border:1px solid #21293a;border-radius:8px;overflow:hidden;">
        <tr>
          <td style="padding:14px 18px;border-bottom:1px solid #21293a;">
            <div style="font-size:10px;color:#00ff88;font-family:'Courier New',monospace;letter-spacing:1px;text-transform:uppercase;margin-bottom:4px;">From</div>
            <div style="font-size:15px;color:#ffffff;font-weight:600;">{$name}</div>
          </td>
        </tr>
        <tr>
          <td style="padding:14px 18px;border-bottom:1px solid #21293a;">
            <div style="font-size:10px;color:#00ff88;font-family:'Courier New',monospace;letter-spacing:1px;text-transform:uppercase;margin-bottom:4px;">Email</div>
            <a href="mailto:{$email}" style="font-size:15px;color:#00d4ff;text-decoration:none;">{$email}</a>
          </td>
        </tr>
        <tr>
          <td style="padding:14px 18px;border-bottom:1px solid #21293a;">
            <div style="font-size:10px;color:#00ff88;font-family:'Courier New',monospace;letter-spacing:1px;text-transform:uppercase;margin-bottom:4px;">Subject</div>
            <div style="font-size:15px;color:#c9d1d9;">{$subject}</div>
          </td>
        </tr>
        <tr>
          <td style="padding:14px 18px;">
            <div style="font-size:10px;color:#00ff88;font-family:'Courier New',monospace;letter-spacing:1px;text-transform:uppercase;margin-bottom:4px;">Received</div>
            <div style="font-size:13px;color:#6e7681;">{$date}</div>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- Message -->
  <tr>
    <td style="padding:20px 32px 0;">
      <div style="font-size:10px;color:#00ff88;font-family:'Courier New',monospace;letter-spacing:1px;text-transform:uppercase;margin-bottom:8px;">Message</div>
      <div style="background:#0d1117;border:1px solid #21293a;border-left:3px solid #00ff88;border-radius:6px;padding:18px;font-size:14px;color:#c9d1d9;line-height:1.8;">{$safe}</div>
    </td>
  </tr>

  <!-- CTA -->
  <tr>
    <td style="padding:28px 32px;text-align:center;">
      <a href="mailto:{$email}?subject=Re: {$subject}"
         style="display:inline-block;background:#00ff88;color:#080b10;font-weight:700;font-size:14px;padding:13px 30px;border-radius:6px;text-decoration:none;font-family:'Courier New',monospace;">
        Reply to {$name} &rarr;
      </a>
    </td>
  </tr>

  <!-- Footer -->
  <tr>
    <td style="padding:16px 32px;border-top:1px solid #21293a;text-align:center;">
      <p style="margin:0;font-size:11px;color:#6e7681;font-family:'Courier New',monospace;">
        Sent via your portfolio &nbsp;&middot;&nbsp; chatebchilima20@gmail.com
      </p>
    </td>
  </tr>

</table>
</td></tr>
</table>
</body>
</html>
HTML;
}

function buildText(string $name, string $email, string $subject, string $message): string {
    $date = date('D, d M Y \a\t H:i T');
    return <<<TEXT
NEW PORTFOLIO INQUIRY
=====================
From:     {$name}
Email:    {$email}
Subject:  {$subject}
Received: {$date}

Message:
--------
{$message}

=====================
Reply to: {$email}
TEXT;
}
