<?php
$pageTitle = 'Blog — Chate.dev';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';

$db = getDB();
$posts = $db->query("SELECT * FROM posts ORDER BY created_at DESC")->fetchAll();
?>

<section class="page-hero">
    <div class="page-hero-inner">
        <p class="section-tag" style="margin-bottom:1rem" data-reveal>Writing</p>
        <h1 class="page-hero-title" data-reveal>
            The <span class="accent">Blog</span>
        </h1>
        <p class="page-hero-sub" data-reveal>
            Thoughts on code, architecture, developer tools, and lessons from the trenches.
        </p>
    </div>
</section>

<div class="blog-grid" style="padding:0 2rem 6rem;">
    <div style="max-width:900px;margin:0 auto;width:100%;">
        <?php if (empty($posts)): ?>
        <div class="no-posts">
            <div class="icon">📝</div>
            <h3 style="color:#fff;margin-bottom:0.5rem">No posts yet</h3>
            <p>Check back soon — articles are on the way.</p>
        </div>
        <?php else: ?>
        <?php foreach ($posts as $i => $post):
            $tags = array_filter(array_map('trim', explode(',', $post['tags'] ?? '')));
            $date = date('M d, Y', strtotime($post['created_at']));
            $readTime = max(1, ceil(str_word_count(strip_tags($post['content'])) / 200));
        ?>
        <a href="/post.php?slug=<?= urlencode($post['slug']) ?>" class="post-card" data-reveal style="animation-delay: <?= $i * 0.08 ?>s">
            <div class="post-meta">
                <span><?= $date ?></span>
                <span class="sep">·</span>
                <span><?= $readTime ?> min read</span>
                <?php if (!empty($tags)): ?>
                <span class="sep">·</span>
                <div class="post-tags" style="margin:0">
                    <?php foreach (array_slice($tags, 0, 2) as $tag): ?>
                    <span class="post-tag"><?= htmlspecialchars($tag) ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <h2 class="post-title"><?= htmlspecialchars($post['title']) ?></h2>
            <p class="post-excerpt">
                <?= htmlspecialchars($post['excerpt'] ?: mb_substr(strip_tags($post['content']), 0, 200) . '...') ?>
            </p>
            <span class="read-more">
                Read article
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </span>
        </a>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
