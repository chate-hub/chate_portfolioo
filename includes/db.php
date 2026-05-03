<?php
define('DB_PATH', __DIR__ . '/../data/portfolio.db');

function getDB(): PDO {
    if (!file_exists(dirname(DB_PATH))) {
        mkdir(dirname(DB_PATH), 0755, true);
    }
    $db = new PDO('sqlite:' . DB_PATH);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $db->exec("
        CREATE TABLE IF NOT EXISTS posts (
            id          INTEGER PRIMARY KEY AUTOINCREMENT,
            title       TEXT NOT NULL,
            slug        TEXT NOT NULL UNIQUE,
            excerpt     TEXT,
            content     TEXT NOT NULL,
            tags        TEXT,
            image       TEXT,
            created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at  DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS projects (
            id          INTEGER PRIMARY KEY AUTOINCREMENT,
            title       TEXT NOT NULL,
            description TEXT NOT NULL,
            stack       TEXT NOT NULL,
            live_url    TEXT,
            github_url  TEXT,
            featured    INTEGER DEFAULT 0,
            sort_order  INTEGER DEFAULT 0,
            created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS admin_users (
            id          INTEGER PRIMARY KEY AUTOINCREMENT,
            username    TEXT NOT NULL UNIQUE,
            password    TEXT NOT NULL,
            created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ");

    // Add image column to posts if upgrading from older schema
    try {
        $db->exec("ALTER TABLE posts ADD COLUMN image TEXT");
    } catch (PDOException $e) { /* column already exists */ }

    // Seed admin
    $stmt = $db->query("SELECT COUNT(*) as c FROM admin_users");
    if ($stmt->fetch()['c'] === 0) {
        $hash = password_hash('admin123', PASSWORD_DEFAULT);
        $db->exec("INSERT INTO admin_users (username, password) VALUES ('admin', '$hash')");
    }

    // Seed projects from hardcoded list if table is empty
    $stmt = $db->query("SELECT COUNT(*) as c FROM projects");
    if ($stmt->fetch()['c'] === 0) {
        $seeds = [
            ['E-Commerce Platform', 'Full-featured multi-tenant e-commerce platform with real-time inventory, payment processing, and a powerful merchant dashboard.', 'PHP,Laravel,MySQL,Vue.js,Stripe,Redis', 'http://willowsadventures.store/', '', 1, 1],
            ['Butchery Ordering App', 'A cross-platform mobile app that lets customers browse cuts, place orders, schedule deliveries, and pay seamlessly. Built for a local butchery to modernise their sales and inventory workflow.', 'Flutter,Dart,Firebase,Node.js,PostgreSQL', '', '', 1, 2],
            ['Real-time Chat API', 'WebSocket-powered chat backend with rooms, private messaging, file sharing, and end-to-end encryption support.', 'Node.js,Socket.io,PostgreSQL,Redis,Docker', '', '', 0, 3],
            ['Analytics Dashboard', 'Interactive data visualization dashboard with custom charting, multi-source data ingestion, and exportable reports.', 'React,TypeScript,D3.js,PHP,MySQL', '', '', 1, 4],
            ['AI Content Pipeline', 'Automated content generation and publishing pipeline integrating OpenAI GPT, content scheduling, and SEO analysis.', 'Python,FastAPI,OpenAI,PostgreSQL,React', '', '', 0, 5],
            ['Auth Microservice', 'Production-ready authentication microservice with OAuth 2.0, JWT, MFA, RBAC, and full audit logging.', 'PHP,JWT,OAuth2,MySQL,Docker', '', '', 0, 6],
            ['Task Manager App', 'Productivity app with Kanban boards, team collaboration, time tracking, and native mobile experience via PWA.', 'Vue.js,Laravel,MySQL,Pusher,PWA', '', '', 1, 7],
        ];
        $ins = $db->prepare("INSERT INTO projects (title,description,stack,live_url,github_url,featured,sort_order) VALUES (?,?,?,?,?,?,?)");
        foreach ($seeds as $s) $ins->execute($s);
    }

    return $db;
}

function slugify(string $text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}
