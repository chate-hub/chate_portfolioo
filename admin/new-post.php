<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
requireLogin();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title'] ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $tags    = trim($_POST['tags'] ?? '');
    
    if (empty($title) || empty($content)) {
        $error = 'Title and content are required.';
    } else {
        $db = getDB();
        $slug = slugify($title);
        
        // Ensure unique slug
        $check = $db->prepare("SELECT id FROM posts WHERE slug = ?");
        $check->execute([$slug]);
        if ($check->fetch()) {
            $slug .= '-' . time();
        }
        
        $stmt = $db->prepare("
            INSERT INTO posts (title, slug, excerpt, content, tags) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$title, $slug, $excerpt, $content, $tags]);
        
        header('Location: /admin/dashboard.php?created=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post — Admin</title>
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
            <a href="/admin/new-post.php" class="admin-nav-link active">
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
            <h1 class="admin-title">New Post</h1>
            <p class="admin-subtitle">// Write and publish a new blog article</p>
        </div>
        
        <?php if ($error): ?>
        <div class="alert alert-error" style="margin-bottom:1.5rem"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" action="/admin/new-post.php">
            <div class="admin-card">
                <div class="admin-card-title">Post Details</div>
                
                <div class="form-group" style="margin-bottom:1.2rem">
                    <label class="form-label">// Title *</label>
                    <input 
                        type="text" name="title" id="post-title"
                        class="form-input" 
                        placeholder="Your amazing post title..."
                        value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                        required>
                    <div style="font-size:0.72rem;color:var(--text-dim);margin-top:0.4rem">
                        URL preview: <span id="slug-preview" style="color:var(--accent2)">/blog/your-post-title</span>
                    </div>
                </div>
                
                <div class="form-group" style="margin-bottom:1.2rem">
                    <label class="form-label">// Excerpt (optional)</label>
                    <textarea 
                        name="excerpt" class="form-textarea" rows="2"
                        placeholder="A brief summary shown on the blog listing page..."
                        style="min-height:70px"><?= htmlspecialchars($_POST['excerpt'] ?? '') ?></textarea>
                </div>
                
                <div class="form-group" style="margin-bottom:1.2rem">
                    <label class="form-label">// Tags (comma separated)</label>
                    <input 
                        type="text" name="tags"
                        class="form-input"
                        placeholder="php, laravel, api, tutorial"
                        value="<?= htmlspecialchars($_POST['tags'] ?? '') ?>">
                </div>
            </div>
            
            <div class="admin-card">
                <div class="admin-card-title">Content *</div>
                
                <div class="editor-toolbar">
                    <button type="button" class="editor-btn" data-wrap="**" title="Bold">B</button>
                    <button type="button" class="editor-btn" data-wrap="*" title="Italic"><em>I</em></button>
                    <button type="button" class="editor-btn" data-wrap="`" title="Code">&lt;/&gt;</button>
                    <button type="button" class="editor-btn" data-insert="## " title="Heading">H2</button>
                    <button type="button" class="editor-btn" data-insert="### " title="Sub-heading">H3</button>
                    <button type="button" class="editor-btn" data-insert="```&#10;code here&#10;```&#10;" title="Code Block">{ }</button>
                    <button type="button" class="editor-btn" data-insert="- " title="List item">—</button>
                    <button type="button" class="editor-btn" data-insert="> " title="Quote">❝</button>
                    <button type="button" class="editor-btn" data-insert="[link text](https://url.com)" title="Link">🔗</button>
                </div>
                
                <textarea 
                    name="content" id="post-content"
                    class="editor-area"
                    placeholder="Write your post content here...

You can use markdown-style formatting:
## Heading
**bold**, *italic*, `code`

```
code block
```

> blockquote"
                    required><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
                <p style="font-size:0.72rem;color:var(--text-dim);margin-top:0.5rem">
                    💡 Tip: Use markdown-style formatting. HTML is also supported.
                </p>
            </div>
            
            <div style="display:flex;gap:1rem;align-items:center">
                <button type="submit" class="btn btn-primary">
                    🚀 Publish Post
                </button>
                <a href="/admin/dashboard.php" class="btn btn-outline">Cancel</a>
                <span style="font-size:0.78rem;color:var(--text-dim);margin-left:auto">
                    * Required fields
                </span>
            </div>
        </form>
    </div>
</div>

<script src="/assets/js/main.js"></script>
</body>
</html>
