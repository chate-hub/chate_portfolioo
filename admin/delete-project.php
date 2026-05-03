<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /admin/projects.php'); exit; }
$id = (int)($_POST['id'] ?? 0);
if ($id) {
    $db = getDB();
    $db->prepare("DELETE FROM projects WHERE id = ?")->execute([$id]);
}
header('Location: /admin/projects.php?msg=Project+deleted');
exit;
