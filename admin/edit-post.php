<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
requireLogin();

$db = getDB();
$id = (int)($_GET['id'] ?? 0);

if (!$id) { header('Location: /admin/dashboard.php'); exit; }

$stmt = $db->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();
if (!$post) { header('Location: /admin/dashboard.php'); exit; }

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title'] ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $tags    = trim($_POST['tags'] ?? '');
    
    if (empty($title) || empty($content)) {
        $error = 'Title and content are required.';
    } else {
        $stmt = $db->prepare("
            UPDATE posts SET title=?, excerpt=?, content=?, tags=?, updated_at=CURRENT_TIMESTAMP
            WHERE id=?
        ");
        $stmt->execute([$title, $excerpt, $content, $tags, $id]);
        header('Location: /admin/dashboard.php?updated=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<div class="noise-overlay"></div>
<div class="cursor-dot" id="cursorDot"></div>
<div class="cursor-ring" id="cursorRing"></div>

<div class="admin-layout">
    <aside class="admin-sidebar">
        <div class="admin-logo">
            ⚡ Dev Panel
            <small>Welcome, <?= htmlspecialchars($_SESSION['admin_user']) ?></small>
        </div>
        <nav class="admin-nav">
            <a href="/admin/dashboard.php" class="admin-nav-link">
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
            <a href="/admin/logout.php" class="admin-nav-link" style="color:var(--accent3)">
                <span class="icon">🚪</span> Logout
            </a>
        </nav>
    </aside>
    
    <div class="admin-main">
        <div class="admin-header">
            <h1 class="admin-title">Edit Post</h1>
            <p class="admin-subtitle">// Editing: <?= htmlspecialchars($post['title']) ?></p>
        </div>
        
        <?php if ($error): ?>
        <div class="alert alert-error" style="margin-bottom:1.5rem"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="admin-card">
                <div class="admin-card-title">Post Details</div>
                
                <div class="form-group" style="margin-bottom:1.2rem">
                    <label class="form-label">// Title *</label>
                    <input type="text" name="title" id="post-title" class="form-input"
                        value="<?= htmlspecialchars($_POST['title'] ?? $post['title']) ?>" required>
                    <div style="font-size:0.72rem;color:var(--text-dim);margin-top:0.4rem">
                        URL: <span style="color:var(--accent2)">/blog/<?= htmlspecialchars($post['slug']) ?></span>
                        <span style="color:var(--text-dim)">(slug won't change on edit)</span>
                    </div>
                </div>
                
                <div class="form-group" style="margin-bottom:1.2rem">
                    <label class="form-label">// Excerpt</label>
                    <textarea name="excerpt" class="form-textarea" rows="2" style="min-height:70px"><?= htmlspecialchars($_POST['excerpt'] ?? $post['excerpt']) ?></textarea>
                </div>
                
                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">// Tags</label>
                    <input type="text" name="tags" class="form-input"
                        value="<?= htmlspecialchars($_POST['tags'] ?? $post['tags']) ?>"
                        placeholder="php, laravel, tutorial">
                </div>
            </div>
            
            <div class="admin-card">
                <div class="admin-card-title">Content *</div>
                <div class="editor-toolbar">
                    <button type="button" class="editor-btn" data-wrap="**">B</button>
                    <button type="button" class="editor-btn" data-wrap="*"><em>I</em></button>
                    <button type="button" class="editor-btn" data-wrap="`">&lt;/&gt;</button>
                    <button type="button" class="editor-btn" data-insert="## ">H2</button>
                    <button type="button" class="editor-btn" data-insert="### ">H3</button>
                    <button type="button" class="editor-btn" data-insert="```&#10;code&#10;```&#10;">{ }</button>
                    <button type="button" class="editor-btn" data-insert="- ">—</button>
                    <button type="button" class="editor-btn" data-insert="> ">❝</button>
                </div>
                <textarea name="content" id="post-content" class="editor-area" required><?= htmlspecialchars($_POST['content'] ?? $post['content']) ?></textarea>
            </div>
            
            <div style="display:flex;gap:1rem">
                <button type="submit" class="btn btn-primary">💾 Save Changes</button>
                <a href="/admin/dashboard.php" class="btn btn-outline">Cancel</a>
                <a href="/post.php?slug=<?= urlencode($post['slug']) ?>" target="_blank" 
                   class="btn btn-outline" style="margin-left:auto">↗ Preview Post</a>
            </div>
        </form>
    </div>
</div>

<script src="/assets/js/main.js"></script>
</body>
</html>
