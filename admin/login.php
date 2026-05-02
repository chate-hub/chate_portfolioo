<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
startSession();

if (isLoggedIn()) { header('Location: /admin/dashboard.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Please fill in all fields.';
    } elseif (loginAdmin($username, $password)) {
        header('Location: /admin/dashboard.php');
        exit;
    } else {
        $error = 'Invalid credentials. Please try again.';
        sleep(1); // Brute-force delay
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — DevPortfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<div class="noise-overlay"></div>
<div class="cursor-dot" id="cursorDot"></div>
<div class="cursor-ring" id="cursorRing"></div>

<div class="login-page">
    <div class="login-bg"></div>
    <div class="login-card">
        <div class="login-logo">⚡ Admin Panel</div>
        <p class="login-sub">// dev.portfolio — secure access</p>
        
        <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" action="/admin/login.php">
            <div class="form-group" style="margin-bottom:1.2rem">
                <label class="form-label">// Username</label>
                <input 
                    type="text" name="username" 
                    class="form-input" 
                    placeholder="admin"
                    value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                    autocomplete="username"
                    required>
            </div>
            <div class="form-group" style="margin-bottom:1.8rem">
                <label class="form-label">// Password</label>
                <input 
                    type="password" name="password"
                    class="form-input"
                    placeholder="••••••••"
                    autocomplete="current-password"
                    required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                Access Dashboard →
            </button>
        </form>
        
        <p style="text-align:center;font-size:0.75rem;color:var(--text-dim);margin-top:1.5rem">
            <a href="/" style="color:var(--accent2)">← Back to portfolio</a>
        </p>
        
        <div style="margin-top:2rem;padding:1rem;background:var(--bg3);border-radius:6px;font-size:0.72rem;color:var(--text-dim)">
            <strong style="color:var(--accent)">Default credentials:</strong><br>
            Username: <code style="color:var(--accent2)">admin</code> / Password: <code style="color:var(--accent2)">admin123</code><br>
            <span style="color:var(--accent3)">⚠ Change these in production!</span>
        </div>
    </div>
</div>
<script src="/assets/js/main.js"></script>
</body>
</html>
