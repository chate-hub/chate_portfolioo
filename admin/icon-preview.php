<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/icons.php';
requireLogin();

header('Content-Type: application/json');

$title = $_GET['title'] ?? '';
$stack = $_GET['stack'] ?? '';
$svg   = projectIcon($title, $stack);

// Resize to 28x28 for preview
$svg = str_replace('width="48" height="48"', 'width="28" height="28"', $svg);

echo json_encode(['svg' => $svg]);
