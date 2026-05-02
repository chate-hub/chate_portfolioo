<?php
echo "<pre>";

// Check SQLite
echo "SQLite3 loaded: " . (extension_loaded('sqlite3') ? "YES ✓" : "NO ✗") . "\n";
echo "PDO SQLite loaded: " . (extension_loaded('pdo_sqlite') ? "YES ✓" : "NO ✗") . "\n";

// Check data folder
$dataDir = __DIR__ . '/data';
echo "data/ exists: " . (file_exists($dataDir) ? "YES ✓" : "NO ✗") . "\n";
echo "data/ writable: " . (is_writable($dataDir) ? "YES ✓" : "NO ✗") . "\n";

// Try creating the DB
try {
    require_once __DIR__ . '/includes/db.php';
    $db = getDB();
    $row = $db->query("SELECT COUNT(*) as c FROM admin_users")->fetch();
    echo "Admin users in DB: " . $row['c'] . "\n";
    echo "\nAll good! Try logging in now.\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "</pre>";
