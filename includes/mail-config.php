<?php
// ============================================================
//  SMTP Configuration
//  This file is in .gitignore — never commit it to GitHub
//  Upload it manually to your server via FTP or SSH
// ============================================================

// ── Detect environment ──────────────────────────────────────
// Automatically switches config between localhost and Hostinger
$isLive = ($_SERVER['HTTP_HOST'] ?? '') !== 'localhost'
       && ($_SERVER['HTTP_HOST'] ?? '') !== '127.0.0.1';

if ($isLive) {

    // ╔══════════════════════════════════╗
    // ║  LIVE SERVER        ║
    // ║  Port 465 · SSL                  ║
    // ╚══════════════════════════════════╝
    define('SMTP_HOST',       'smtp.gmail.com');
    define('SMTP_PORT',       465);
    define('SMTP_ENCRYPTION', 'ssl');           // <-- SSL 

} else {

    // ╔══════════════════════════════════╗
    // ║  LOCAL DEV (localhost)           ║
    // ║  Port 587 · STARTTLS             ║
    // ╚══════════════════════════════════╝
    define('SMTP_HOST',       'smtp.gmail.com');
    define('SMTP_PORT',       587);
    define('SMTP_ENCRYPTION', 'tls');           // <-- STARTTLS for localhost

}

// ── Credentials (same for both environments) ────────────────
define('SMTP_USERNAME',  'chatebchilima20@gmail.com');
define('SMTP_PASSWORD',  'ulee baaq rgdt mtey');   
define('SMTP_FROM',      'chatebchilima20@gmail.com');
define('SMTP_FROM_NAME', 'Chate Billy Chilima — Portfolio');
define('MAIL_TO',        'chatebchilima20@gmail.com');
