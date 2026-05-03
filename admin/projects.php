<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/icons.php';
requireLogin();

$db       = getDB();
$projects = $db->query("SELECT * FROM projects ORDER BY sort_order ASC, id ASC")->fetchAll();
$flash    = $_GET['msg'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <title>All Projects — Admin</title>
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
            <h1 class="admin-title">All Projects</h1>
            <p class="admin-subtitle">// <?= count($projects) ?> project<?= count($projects) !== 1 ? 's' : '' ?> · icons assigned automatically</p>
        </div>

        <?php if ($flash): ?>
        <div class="alert <?= str_contains($flash,'deleted') ? 'alert-error' : 'alert-success' ?>" style="margin-bottom:1.5rem">
            <?= htmlspecialchars($flash) ?>
        </div>
        <?php endif; ?>

        <div style="margin-bottom:1.5rem">
            <a href="/admin/new-project.php" class="btn btn-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add New Project
            </a>
        </div>

        <div class="admin-card" style="padding:0;overflow:hidden">
            <?php if (empty($projects)): ?>
            <div style="text-align:center;padding:3rem;color:var(--text-dim)">
                No projects yet. <a href="/admin/new-project.php" style="color:var(--accent)">Add your first project &rarr;</a>
            </div>
            <?php else: ?>
            <table class="posts-table">
                <thead>
                    <tr>
                        <th style="width:60px">Icon</th>
                        <th>Title</th>
                        <th>Stack</th>
                        <th>Links</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($projects as $p):
                    $icon      = projectIcon($p['title'], $p['stack']);
                    $stackArr  = array_map('trim', explode(',', $p['stack']));
                ?>
                <tr>
                    <td>
                        <div style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;background:var(--bg3);border-radius:8px;color:var(--accent)">
                            <?= str_replace('width="48" height="48"', 'width="22" height="22"', $icon) ?>
                        </div>
                    </td>
                    <td>
                        <span style="color:#fff;font-weight:500"><?= htmlspecialchars($p['title']) ?></span>
                    </td>
                    <td>
                        <div style="display:flex;flex-wrap:wrap;gap:0.3rem;max-width:220px">
                            <?php foreach (array_slice($stackArr, 0, 4) as $t): ?>
                            <span class="tag" style="font-size:0.68rem"><?= htmlspecialchars($t) ?></span>
                            <?php endforeach; ?>
                            <?php if (count($stackArr) > 4): ?>
                            <span class="tag" style="font-size:0.68rem;color:var(--text-dim)">+<?= count($stackArr) - 4 ?></span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <div style="display:flex;flex-direction:column;gap:0.3rem;font-size:0.75rem">
                            <?php if (!empty($p['live_url'])): ?>
                            <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" style="color:var(--accent2)">↗ Live</a>
                            <?php else: ?><span style="color:var(--text-dim)">No live URL</span><?php endif; ?>
                            <?php if (!empty($p['github_url'])): ?>
                            <a href="<?= htmlspecialchars($p['github_url']) ?>" target="_blank" style="color:var(--text-dim)">⌥ GitHub</a>
                            <?php else: ?><span style="color:var(--text-dim)">No GitHub</span><?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <?php if ($p['featured']): ?>
                        <span style="color:var(--accent3);font-size:0.78rem">&#9733; Yes</span>
                        <?php else: ?>
                        <span style="color:var(--text-dim);font-size:0.78rem">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display:flex;gap:0.5rem;align-items:center">
                            <a href="/admin/edit-project.php?id=<?= $p['id'] ?>" class="btn btn-outline" style="padding:0.3rem 0.7rem;font-size:0.72rem">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit
                            </a>
                            <form method="POST" action="/admin/delete-project.php" style="margin:0">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
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
