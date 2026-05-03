<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/icons.php';
requireLogin();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = trim($_POST['title']       ?? '');
    $desc     = trim($_POST['description'] ?? '');
    $stack    = trim($_POST['stack']       ?? '');
    $live     = trim($_POST['live_url']    ?? '');
    $github   = trim($_POST['github_url']  ?? '');
    $featured = isset($_POST['featured']) ? 1 : 0;
    $order    = (int)($_POST['sort_order'] ?? 99);

    if (empty($title) || empty($desc) || empty($stack)) {
        $error = 'Title, description and stack are required.';
    } else {
        $db   = getDB();
        $stmt = $db->prepare("INSERT INTO projects (title,description,stack,live_url,github_url,featured,sort_order) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute([$title, $desc, $stack, $live, $github, $featured, $order]);
        header('Location: /admin/projects.php?msg=Project+added+successfully');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <title>New Project — Admin</title>
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
            <h1 class="admin-title">New Project</h1>
            <p class="admin-subtitle">// Icon is assigned automatically based on title &amp; stack</p>
        </div>

        <?php if ($error): ?>
        <div class="alert alert-error" style="margin-bottom:1.5rem"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="admin-card">
                <div class="admin-card-title">Project Details</div>

                <!-- Icon preview -->
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;padding:1rem;background:var(--bg3);border-radius:8px;border:1px solid var(--border)">
                    <div id="iconPreview" style="width:52px;height:52px;display:flex;align-items:center;justify-content:center;background:var(--surface);border:1px solid var(--border);border-radius:12px;color:var(--accent);flex-shrink:0">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="28" height="28"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    </div>
                    <div>
                        <div style="font-size:0.75rem;color:var(--accent);font-family:var(--font-mono)">// Auto icon preview</div>
                        <div style="font-size:0.8rem;color:var(--text-dim);margin-top:0.2rem">Updates as you type the title and stack</div>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:1.2rem">
                    <label class="form-label">// Project Title *</label>
                    <input type="text" name="title" id="proj-title" class="form-input" placeholder="e.g. E-Commerce Platform" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
                </div>

                <div class="form-group" style="margin-bottom:1.2rem">
                    <label class="form-label">// Description *</label>
                    <textarea name="description" class="form-textarea" rows="3" style="min-height:90px" placeholder="What does this project do? Who is it for?" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                </div>

                <div class="form-group" style="margin-bottom:1.2rem">
                    <label class="form-label">// Tech Stack * <span style="color:var(--text-dim);font-weight:400">(comma separated)</span></label>
                    <input type="text" name="stack" id="proj-stack" class="form-input" placeholder="PHP, Laravel, MySQL, Vue.js" value="<?= htmlspecialchars($_POST['stack'] ?? '') ?>" required>
                    <div style="font-size:0.72rem;color:var(--text-dim);margin-top:0.4rem">e.g. Flutter, Dart, Firebase, Node.js</div>
                </div>
            </div>

            <div class="admin-card">
                <div class="admin-card-title">Links &amp; Options</div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.2rem">
                    <div class="form-group">
                        <label class="form-label">// Live URL</label>
                        <input type="url" name="live_url" class="form-input" placeholder="https://yourproject.com" value="<?= htmlspecialchars($_POST['live_url'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">// GitHub URL</label>
                        <input type="url" name="github_url" class="form-input" placeholder="https://github.com/you/repo" value="<?= htmlspecialchars($_POST['github_url'] ?? '') ?>">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:0">
                    <div class="form-group">
                        <label class="form-label">// Sort Order</label>
                        <input type="number" name="sort_order" class="form-input" placeholder="1" min="1" value="<?= htmlspecialchars($_POST['sort_order'] ?? '99') ?>">
                        <div style="font-size:0.72rem;color:var(--text-dim);margin-top:0.4rem">Lower = shown first</div>
                    </div>
                    <div class="form-group" style="justify-content:flex-end;padding-top:1.8rem">
                        <label style="display:flex;align-items:center;gap:0.7rem;cursor:none">
                            <input type="checkbox" name="featured" id="feat-check" <?= isset($_POST['featured']) ? 'checked' : '' ?> style="width:18px;height:18px;accent-color:var(--accent)">
                            <span style="font-size:0.85rem;color:var(--text)">Mark as Featured &#9733;</span>
                        </label>
                    </div>
                </div>
            </div>

            <div style="display:flex;gap:1rem">
                <button type="submit" class="btn btn-primary">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Save Project
                </button>
                <a href="/admin/projects.php" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
<script src="/assets/js/main.js"></script>
<script>
// Live icon preview via API call
const titleEl = document.getElementById('proj-title');
const stackEl = document.getElementById('proj-stack');
const preview = document.getElementById('iconPreview');

let debounce;
function updatePreview() {
    clearTimeout(debounce);
    debounce = setTimeout(async () => {
        const t = titleEl.value.trim();
        const s = stackEl.value.trim();
        if (!t && !s) return;
        try {
            const res  = await fetch(`/admin/icon-preview.php?title=${encodeURIComponent(t)}&stack=${encodeURIComponent(s)}`);
            const data = await res.json();
            if (data.svg) preview.innerHTML = data.svg;
        } catch(e) {}
    }, 400);
}
titleEl.addEventListener('input', updatePreview);
stackEl.addEventListener('input', updatePreview);
</script>
</body>
</html>
