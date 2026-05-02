<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /admin/dashboard.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);
if (!$id) {
    header('Location: /admin/dashboard.php');
    exit;
}

$db = getDB();
$stmt = $db->prepare("DELETE FROM posts WHERE id = ?");
$stmt->execute([$id]);

header('Location: /admin/dashboard.php?deleted=1');
exit;
