<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
requireLogin();

$db           = getDB();
$posts        = $db->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT 5")->fetchAll();
$postCount    = $db->query("SELECT COUNT(*) as c FROM posts")->fetch()['c'];
$projectCount = $db->query("SELECT COUNT(*) as c FROM projects")->fetch()['c'];
$flash        = $_GET['created'] ?? $_GET['updated'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard — Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<div class="noise-overlay"></div>
<div class="cursor-dot" id="cursorDot"></div>
<div class="cursor-ring" id="cursorRing"></div>
<div class="admin-layout">
    <?php require __DIR__ . '/sidebar.php'; ?>
    <div class="admin-main">

        <div class="admin-header">
            <h1 class="admin-title">Dashboard</h1>
            <p class="admin-subtitle">// Manage your portfolio content</p>
        </div>

        <?php if ($flash): ?>
        <div class="alert alert-success" style="margin-bottom:1.5rem">
            <?= $flash === '1' ? 'Post published successfully!' : 'Post updated.' ?>
        </div>
        <?php endif; ?>

        <!-- Stats -->
        <div class="admin-stats">
            <div class="admin-stat">
                <div class="admin-stat-num"><?= $postCount ?></div>
                <div class="admin-stat-label">Blog Posts</div>
            </div>
            <div class="admin-stat" style="border-left-color:var(--accent2)">
                <div class="admin-stat-num" style="color:var(--accent2)"><?= $projectCount ?></div>
                <div class="admin-stat-label">Projects</div>
            </div>
            <div class="admin-stat" style="border-left-color:var(--accent3)">
                <div class="admin-stat-num" style="color:var(--accent3)">&#8734;</div>
                <div class="admin-stat-label">Coffee Consumed</div>
            </div>
        </div>

        <!-- Quick actions -->
        <div style="display:flex;gap:1rem;margin-bottom:2rem;flex-wrap:wrap">
            <a href="/admin/new-post.php" class="btn btn-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Post
            </a>
            <a href="/admin/new-project.php" class="btn btn-outline">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Project
            </a>
        </div>

        <!-- Recent posts -->
        <div class="admin-card">
            <div class="admin-card-title" style="display:flex;justify-content:space-between;align-items:center">
                Recent Posts
                <a href="/admin/posts.php" style="font-size:0.78rem;color:var(--accent2);font-weight:400">View all &rarr;</a>
            </div>
            <?php if (empty($posts)): ?>
            <div style="text-align:center;padding:2rem;color:var(--text-dim)">
                No posts yet. <a href="/admin/new-post.php" style="color:var(--accent)">Write your first &rarr;</a>
            </div>
            <?php else: ?>
            <table class="posts-table">
                <thead><tr><th>Title</th><th>Date</th><th>Actions</th></tr></thead>
                <tbody>
                <?php foreach ($posts as $post): ?>
                <tr>
                    <td>
                        <a href="/post.php?slug=<?= urlencode($post['slug']) ?>" target="_blank"
                           style="color:#fff;transition:color 0.2s"
                           onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color='#fff'">
                            <?= htmlspecialchars(mb_substr($post['title'], 0, 60)) ?>
                        </a>
                    </td>
                    <td style="color:var(--text-dim);font-size:0.8rem;white-space:nowrap"><?= date('d M Y', strtotime($post['created_at'])) ?></td>
                    <td>
                        <div style="display:flex;gap:0.5rem">
                            <a href="/admin/edit-post.php?id=<?= $post['id'] ?>" class="btn btn-outline" style="padding:0.3rem 0.7rem;font-size:0.72rem">Edit</a>
                            <form method="POST" action="/admin/delete-post.php" style="margin:0">
                                <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                <button type="submit" class="btn btn-danger delete-post-btn" style="padding:0.3rem 0.7rem;font-size:0.72rem">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

        <!-- Terminal status -->
        <div class="admin-card">
            <div class="admin-card-title">// System Status</div>
            <div class="terminal-body" style="font-size:0.8rem">
                <div class="t-line"><span class="t-prompt">$</span> <span class="t-cmd">status</span></div>
                <div class="t-line t-out success">&#10003; Portfolio live and running</div>
                <div class="t-line t-out success">&#10003; SQLite connected &mdash; <?= $postCount ?> posts &middot; <?= $projectCount ?> projects</div>
                <div class="t-line" style="margin-top:0.5rem"><span class="t-prompt">$</span> <span class="t-cmd">whoami</span></div>
                <div class="t-line t-out highlight"><?= htmlspecialchars($_SESSION['admin_user']) ?> &mdash; Administrator</div>
                <div class="t-line" style="margin-top:0.5rem"><span class="t-prompt">$</span> <span class="t-cmd">date</span></div>
                <div class="t-line t-out"><?= date('D M d H:i:s T Y') ?></div>
            </div>
        </div>

    </div>
</div>
<script src="/assets/js/main.js"></script>
</body>
</html>
