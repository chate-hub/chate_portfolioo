<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
requireLogin();

$db    = getDB();
$posts = $db->query("SELECT * FROM posts ORDER BY created_at DESC")->fetchAll();

$flash = $_GET['deleted'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <title>All Posts — Admin</title>
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
            <h1 class="admin-title">All Posts</h1>
            <p class="admin-subtitle">// <?= count($posts) ?> article<?= count($posts) !== 1 ? 's' : '' ?> published</p>
        </div>

        <?php if ($flash): ?>
        <div class="alert alert-error" style="margin-bottom:1.5rem">Post deleted successfully.</div>
        <?php endif; ?>

        <div style="margin-bottom:1.5rem">
            <a href="/admin/new-post.php" class="btn btn-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Post
            </a>
        </div>

        <div class="admin-card" style="padding:0;overflow:hidden">
            <?php if (empty($posts)): ?>
            <div style="text-align:center;padding:3rem;color:var(--text-dim)">
                No posts yet. <a href="/admin/new-post.php" style="color:var(--accent)">Write your first post &rarr;</a>
            </div>
            <?php else: ?>
            <table class="posts-table">
                <thead>
                    <tr>
                        <th style="width:40px">#</th>
                        <th>Title</th>
                        <th>Tags</th>
                        <th>Image</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($posts as $i => $post):
                    $tags = array_filter(array_map('trim', explode(',', $post['tags'] ?? '')));
                    $date = date('d M Y', strtotime($post['created_at']));
                ?>
                <tr>
                    <td style="color:var(--text-dim);font-size:0.75rem"><?= $i + 1 ?></td>
                    <td>
                        <a href="/post.php?slug=<?= urlencode($post['slug']) ?>" target="_blank"
                           style="color:#fff;font-weight:500;transition:color 0.2s"
                           onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color='#fff'">
                            <?= htmlspecialchars(mb_substr($post['title'], 0, 55)) ?><?= mb_strlen($post['title']) > 55 ? '…' : '' ?>
                        </a>
                    </td>
                    <td>
                        <div style="display:flex;flex-wrap:wrap;gap:0.3rem">
                            <?php foreach (array_slice($tags, 0, 3) as $tag): ?>
                            <span class="post-tag"><?= htmlspecialchars($tag) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </td>
                    <td>
                        <?php if (!empty($post['image'])): ?>
                        <img src="<?= htmlspecialchars($post['image']) ?>" alt="" style="width:48px;height:36px;object-fit:cover;border-radius:4px;border:1px solid var(--border)">
                        <?php else: ?>
                        <span style="color:var(--text-dim);font-size:0.75rem">—</span>
                        <?php endif; ?>
                    </td>
                    <td style="color:var(--text-dim);white-space:nowrap;font-size:0.82rem"><?= $date ?></td>
                    <td>
                        <div style="display:flex;gap:0.5rem;align-items:center">
                            <a href="/admin/edit-post.php?id=<?= $post['id'] ?>" class="btn btn-outline" style="padding:0.3rem 0.7rem;font-size:0.72rem">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit
                            </a>
                            <form method="POST" action="/admin/delete-post.php" style="margin:0">
                                <input type="hidden" name="id" value="<?= $post['id'] ?>">
                                <button type="submit" class="btn btn-danger delete-post-btn">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    Delete
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

    </div>
</div>
<script src="/assets/js/main.js"></script>
</body>
</html>
