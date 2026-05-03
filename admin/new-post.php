<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
requireLogin();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title']   ?? '');
    $excerpt = trim($_POST['excerpt'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $tags    = trim($_POST['tags']    ?? '');
    $image   = '';

    if (empty($title) || empty($content)) {
        $error = 'Title and content are required.';
    } else {
        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $allowed = ['image/jpeg','image/png','image/gif','image/webp'];
            $maxSize = 3 * 1024 * 1024; // 3MB
            if (!in_array($_FILES['image']['type'], $allowed)) {
                $error = 'Image must be JPG, PNG, GIF or WebP.';
            } elseif ($_FILES['image']['size'] > $maxSize) {
                $error = 'Image must be under 3MB.';
            } else {
                $ext      = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = 'post-' . time() . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
                $dest     = __DIR__ . '/../assets/uploads/' . $filename;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
                    $image = '/assets/uploads/' . $filename;
                }
            }
        }

        if (!$error) {
            $db   = getDB();
            $slug = slugify($title);
            $chk  = $db->prepare("SELECT id FROM posts WHERE slug = ?");
            $chk->execute([$slug]);
            if ($chk->fetch()) $slug .= '-' . time();

            $db->prepare("INSERT INTO posts (title,slug,excerpt,content,tags,image) VALUES (?,?,?,?,?,?)")
               ->execute([$title, $slug, $excerpt, $content, $tags, $image]);
            header('Location: /admin/posts.php?created=1');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <title>New Post — Admin</title>
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
            <h1 class="admin-title">New Post</h1>
            <p class="admin-subtitle">// Write and publish a new blog article</p>
        </div>

        <?php if ($error): ?>
        <div class="alert alert-error" style="margin-bottom:1.5rem"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="admin-card">
                <div class="admin-card-title">Post Details</div>

                <div class="form-group" style="margin-bottom:1.2rem">
                    <label class="form-label">// Title *</label>
                    <input type="text" name="title" id="post-title" class="form-input" placeholder="Your article title..." value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
                    <div style="font-size:0.72rem;color:var(--text-dim);margin-top:0.4rem">
                        URL preview: <span id="slug-preview" style="color:var(--accent2)">/blog/your-post-title</span>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:1.2rem">
                    <label class="form-label">// Excerpt <span style="color:var(--text-dim);font-weight:400">(optional — shown on blog listing)</span></label>
                    <textarea name="excerpt" class="form-textarea" rows="2" style="min-height:70px" placeholder="A brief summary..."><?= htmlspecialchars($_POST['excerpt'] ?? '') ?></textarea>
                </div>

                <div class="form-group" style="margin-bottom:1.2rem">
                    <label class="form-label">// Cover Image <span style="color:var(--text-dim);font-weight:400">(optional · JPG/PNG/WebP · max 3MB)</span></label>
                    <div class="image-upload-wrap" id="imageUploadWrap">
                        <input type="file" name="image" id="imageInput" accept="image/*" style="display:none">
                        <div class="image-upload-box" id="imageUploadBox" onclick="document.getElementById('imageInput').click()">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" style="margin-bottom:0.5rem;opacity:0.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <div style="font-size:0.82rem;color:var(--text-dim)">Click to upload cover image</div>
                        </div>
                        <img id="imagePreview" src="" alt="" style="display:none;max-height:180px;border-radius:8px;border:1px solid var(--border);margin-top:0.8rem">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:0">
                    <label class="form-label">// Tags <span style="color:var(--text-dim);font-weight:400">(comma separated)</span></label>
                    <input type="text" name="tags" class="form-input" placeholder="php, laravel, tutorial" value="<?= htmlspecialchars($_POST['tags'] ?? '') ?>">
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
                    <button type="button" class="editor-btn" data-insert="```&#10;code here&#10;```&#10;">{ }</button>
                    <button type="button" class="editor-btn" data-insert="- ">— List</button>
                    <button type="button" class="editor-btn" data-insert="> ">❝ Quote</button>
                    <button type="button" class="editor-btn" data-insert="---&#10;">— Divider</button>
                </div>
                <textarea name="content" id="post-content" class="editor-area" placeholder="Write your post content here..." required><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
            </div>

            <div style="display:flex;gap:1rem;align-items:center">
                <button type="submit" class="btn btn-primary">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13"/><path d="M22 2L15 22 11 13 2 9l20-7z"/></svg>
                    Publish Post
                </button>
                <a href="/admin/posts.php" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
<script src="/assets/js/main.js"></script>
<script>
// Image preview
document.getElementById('imageInput').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const prev = document.getElementById('imagePreview');
        prev.src = e.target.result;
        prev.style.display = 'block';
        document.getElementById('imageUploadBox').style.display = 'none';
    };
    reader.readAsDataURL(file);
});
</script>
</body>
</html>
