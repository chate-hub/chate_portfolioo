<?php
function startSession(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function isLoggedIn(): bool {
    startSession();
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: /admin/login.php');
        exit;
    }
}

function loginAdmin(string $username, string $password): bool {
    require_once __DIR__ . '/db.php';
    startSession();
    
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_user'] = $user['username'];
        return true;
    }
    return false;
}

function logoutAdmin(): void {
    startSession();
    session_destroy();
    header('Location: /admin/login.php');
    exit;
}
