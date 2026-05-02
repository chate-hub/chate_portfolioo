<?php
require_once __DIR__ . '/includes/db.php';

$slug = $_GET['slug'] ?? '';
if (!$slug) { header('Location: /blog.php'); exit; }

$db = getDB();
$stmt = $db->prepare("SELECT * FROM posts WHERE slug = ?");
$stmt->execute([$slug]);
$post = $stmt->fetch();

if (!$post) { header('Location: /blog.php'); exit; }

$pageTitle = htmlspecialchars($post['title']) . ' — Chate.dev';
require_once __DIR__ . '/includes/header.php';

$tags = array_filter(array_map('trim', explode(',', $post['tags'] ?? '')));
$date = date('F j, Y', strtotime($post['created_at']));
$readTime = max(1, ceil(str_word_count(strip_tags($post['content'])) / 200));
?>

<section class="post-hero">
    <div class="post-hero-inner">
        <a href="/blog.php" class="back-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Back to Blog
        </a>
        
        <div class="post-meta" style="margin-bottom:1.5rem">
            <span><?= $date ?></span>
            <span class="sep">·</span>
            <span><?= $readTime ?> min read</span>
        </div>
        
        <h1 class="page-hero-title" style="font-size:clamp(2rem,5vw,3.5rem);margin-bottom:1.5rem" data-reveal>
            <?= htmlspecialchars($post['title']) ?>
        </h1>
        
        <?php if (!empty($post['excerpt'])): ?>
        <p style="font-size:1rem;color:var(--text-dim);max-width:600px;line-height:1.8" data-reveal>
            <?= htmlspecialchars($post['excerpt']) ?>
        </p>
        <?php endif; ?>
        
        <?php if (!empty($tags)): ?>
        <div class="post-tags" style="margin-top:1.5rem" data-reveal>
            <?php foreach ($tags as $tag): ?>
            <span class="post-tag"><?= htmlspecialchars($tag) ?></span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <div style="margin-top:2.5rem;padding-top:2rem;border-top:1px solid var(--border);"></div>
    </div>
</section>

<article class="post-content" data-reveal>
    <?= nl2br(htmlspecialchars($post['content'])) ?>
</article>

<div style="max-width:800px;margin:0 auto;padding:0 2rem 6rem;">
    <div style="border-top:1px solid var(--border);padding-top:2rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
        <a href="/blog.php" class="btn btn-outline">← More Articles</a>
        <div style="font-size:0.8rem;color:var(--text-dim)">
            Last updated: <?= date('M d, Y', strtotime($post['updated_at'])) ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
