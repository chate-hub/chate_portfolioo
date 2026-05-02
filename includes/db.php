<?php
define('DB_PATH', __DIR__ . '/../data/portfolio.db');

function getDB(): PDO {
    if (!file_exists(dirname(DB_PATH))) {
        mkdir(dirname(DB_PATH), 0755, true);
    }
    $db = new PDO('sqlite:' . DB_PATH);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Create tables if they don't exist
    $db->exec("
        CREATE TABLE IF NOT EXISTS posts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            slug TEXT NOT NULL UNIQUE,
            excerpt TEXT,
            content TEXT NOT NULL,
            tags TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        
        CREATE TABLE IF NOT EXISTS admin_users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ");
    
    // Seed default admin if none exists
    $stmt = $db->query("SELECT COUNT(*) as count FROM admin_users");
    $row = $stmt->fetch();
    if ($row['count'] === 0) {
        $hash = password_hash('admin123', PASSWORD_DEFAULT);
        $db->exec("INSERT INTO admin_users (username, password) VALUES ('admin', '$hash')");
    }
    
    return $db;
}

function slugify(string $text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}
