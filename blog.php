<?php
$pageTitle = 'Blog — Chate Billy Chilima';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';

$db    = getDB();
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

<div style="padding:0 2rem 6rem;">
    <div style="max-width:860px;margin:0 auto;width:100%;">
        <?php if (empty($posts)): ?>
        <div class="no-posts" style="text-align:center;padding:4rem 2rem;color:var(--text-dim)">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" style="margin:0 auto 1rem;display:block;opacity:0.4"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            <h3 style="color:#fff;margin-bottom:0.5rem">No posts yet</h3>
            <p>Check back soon — articles are on the way.</p>
        </div>
        <?php else: ?>

        <?php foreach ($posts as $i => $post):
            $tags     = array_filter(array_map('trim', explode(',', $post['tags'] ?? '')));
            $date     = date('M d, Y', strtotime($post['created_at']));
            $readTime = max(1, ceil(str_word_count(strip_tags($post['content'])) / 200));
        ?>

        <!-- Post card -->
        <a href="/post.php?slug=<?= urlencode($post['slug']) ?>" class="post-card" data-reveal>

            <?php if (!empty($post['image'])): ?>
            <div class="post-card-image">
                <img src="<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
            </div>
            <?php endif; ?>

            <div class="post-card-body">
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
            </div>
        </a>

        <?php if ($i < count($posts) - 1): ?>
        <!-- Separator between posts -->
        <div class="post-separator" data-reveal>
            <span class="sep-line"></span>
            <span class="sep-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
            </span>
            <span class="sep-line"></span>
        </div>
        <?php endif; ?>

        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
