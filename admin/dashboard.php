<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
requireLogin();

$db = getDB();
$posts = $db->query("SELECT * FROM posts ORDER BY created_at DESC")->fetchAll();
$postCount = count($posts);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<div class="noise-overlay"></div>
<div class="cursor-dot" id="cursorDot"></div>
<div class="cursor-ring" id="cursorRing"></div>

<div class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-logo">
            ⚡ Dev Panel
            <small>Welcome, <?= htmlspecialchars($_SESSION['admin_user']) ?></small>
        </div>
        <nav class="admin-nav">
            <a href="/admin/dashboard.php" class="admin-nav-link active">
                <span class="icon">📊</span> Dashboard
            </a>
            <a href="/admin/new-post.php" class="admin-nav-link">
                <span class="icon">✏️</span> New Post
            </a>
            <a href="/blog.php" class="admin-nav-link" target="_blank">
                <span class="icon">📖</span> View Blog
            </a>
            <a href="/" class="admin-nav-link" target="_blank">
                <span class="icon">🌐</span> View Site
            </a>
            <a href="/admin/logout.php" class="admin-nav-link" style="margin-top:auto;color:var(--accent3)">
                <span class="icon">🚪</span> Logout
            </a>
        </nav>
    </aside>
    
    <!-- Main -->
    <div class="admin-main">
        <div class="admin-header">
            <h1 class="admin-title">Dashboard</h1>
            <p class="admin-subtitle">// Manage your portfolio content</p>
        </div>
        
        <!-- Stats -->
        <div class="admin-stats">
            <div class="admin-stat">
                <div class="admin-stat-num"><?= $postCount ?></div>
                <div class="admin-stat-label">Total Posts</div>
            </div>
            <div class="admin-stat" style="border-left-color:var(--accent2)">
                <div class="admin-stat-num" style="color:var(--accent2)">6</div>
                <div class="admin-stat-label">Projects</div>
            </div>
            <div class="admin-stat" style="border-left-color:var(--accent3)">
                <div class="admin-stat-num" style="color:var(--accent3)">∞</div>
                <div class="admin-stat-label">Coffee Consumed</div>
            </div>
        </div>
        
        <!-- Quick Action -->
        <div style="margin-bottom:2rem">
            <a href="/admin/new-post.php" class="btn btn-primary">
                ✏️ Write New Post
            </a>
        </div>
        
        <!-- Posts Table -->
        <div class="admin-card">
            <div class="admin-card-title">
                Blog Posts 
                <span style="font-size:0.8rem;font-weight:400;color:var(--text-dim);margin-left:0.5rem">(<?= $postCount ?>)</span>
            </div>
            
            <?php if (empty($posts)): ?>
            <div style="text-align:center;padding:3rem;color:var(--text-dim)">
                <div style="font-size:2rem;margin-bottom:1rem">📝</div>
                <p>No posts yet. <a href="/admin/new-post.php" style="color:var(--accent)">Create your first post →</a></p>
            </div>
            <?php else: ?>
            <table class="posts-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Tags</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post):
                        $tags = array_filter(array_map('trim', explode(',', $post['tags'] ?? '')));
                        $date = date('M d, Y', strtotime($post['created_at']));
                    ?>
                    <tr>
                        <td>
                            <a href="/post.php?slug=<?= urlencode($post['slug']) ?>" target="_blank" 
                               style="color:#fff;font-weight:500;transition:color 0.2s"
                               onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color='#fff'">
                                <?= htmlspecialchars(mb_substr($post['title'], 0, 50)) ?><?= strlen($post['title']) > 50 ? '...' : '' ?>
                            </a>
                        </td>
                        <td>
                            <div style="display:flex;flex-wrap:wrap;gap:0.3rem">
                                <?php foreach (array_slice($tags, 0, 3) as $tag): ?>
                                <span class="post-tag"><?= htmlspecialchars($tag) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </td>
                        <td style="color:var(--text-dim);white-space:nowrap"><?= $date ?></td>
                        <td><span class="post-status">Published</span></td>
                        <td>
                            <div style="display:flex;gap:0.5rem;align-items:center">
                                <a href="/admin/edit-post.php?id=<?= $post['id'] ?>" 
                                   class="btn btn-outline" 
                                   style="padding:0.3rem 0.7rem;font-size:0.72rem">
                                   ✏️ Edit
                                </a>
                                <form method="POST" action="/admin/delete-post.php" style="margin:0">
                                    <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                    <button type="submit" class="btn btn-danger delete-post-btn">
                                        🗑 Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        
        <!-- Terminal Activity -->
        <div class="admin-card">
            <div class="admin-card-title">// System Status</div>
            <div class="terminal-body" style="font-size:0.8rem">
                <div class="t-line"><span class="t-prompt">$</span> <span class="t-cmd">uptime</span></div>
                <div class="t-line t-out success">✓ Portfolio running smoothly</div>
                <div class="t-line" style="margin-top:0.5rem"><span class="t-prompt">$</span> <span class="t-cmd">db status</span></div>
                <div class="t-line t-out success">✓ SQLite connected — <?= $postCount ?> posts stored</div>
                <div class="t-line" style="margin-top:0.5rem"><span class="t-prompt">$</span> <span class="t-cmd">whoami</span></div>
                <div class="t-line t-out highlight"><?= htmlspecialchars($_SESSION['admin_user']) ?> — Administrator</div>
                <div class="t-line" style="margin-top:0.5rem"><span class="t-prompt">$</span> <span class="t-cmd">date</span></div>
                <div class="t-line t-out"><?= date('D M d H:i:s T Y') ?></div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/main.js"></script>
</body>
</html>
