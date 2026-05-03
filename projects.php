<?php
$pageTitle = 'Projects — Chate Billy Chilima';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/icons.php';
require_once __DIR__ . '/includes/header.php';

$db       = getDB();
$projects = $db->query("SELECT * FROM projects ORDER BY sort_order ASC, id ASC")->fetchAll();

// Build dynamic filter tags from all stacks in DB
$allTags = ['all'];
foreach ($projects as $p) {
    foreach (array_map('trim', explode(',', $p['stack'])) as $t) {
        $tag = strtolower($t);
        if (!in_array($tag, $allTags)) $allTags[] = $tag;
    }
}
// Limit to sensible filter list (top 8 after 'all')
$filterTags = array_slice($allTags, 0, 9);
?>

<section class="page-hero">
    <div class="page-hero-inner">
        <p class="section-tag" style="margin-bottom:1rem" data-reveal>My Work</p>
        <h1 class="page-hero-title" data-reveal>
            Selected <span class="accent">Projects</span>
        </h1>
        <p class="page-hero-sub" data-reveal>
            A curated collection of things I've built — from SaaS platforms to mobile apps.
            Updated as new work ships.
        </p>
    </div>
</section>

<div class="filter-bar">
    <div class="inner">
        <?php foreach ($filterTags as $tag): ?>
        <button class="filter-btn <?= $tag === 'all' ? 'active' : '' ?>" data-filter="<?= htmlspecialchars($tag) ?>">
            <?= $tag === 'all' ? 'All Projects' : strtoupper($tag) ?>
        </button>
        <?php endforeach; ?>
    </div>
</div>

<div style="max-width:1200px;margin:0 auto;padding:0 2rem 6rem;">
    <?php if (empty($projects)): ?>
    <div class="no-posts" style="text-align:center;padding:4rem 2rem;color:var(--text-dim)">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" style="margin:0 auto 1rem;display:block;opacity:0.4"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
        <h3 style="color:#fff;margin-bottom:0.5rem">No projects yet</h3>
        <p>Add your first project from the <a href="/admin/dashboard.php" style="color:var(--accent)">admin panel</a>.</p>
    </div>
    <?php else: ?>
    <div class="projects-grid" style="max-width:none">
        <?php foreach ($projects as $i => $p):
            $stackArr = array_map('trim', explode(',', $p['stack']));
            $tagsStr  = strtolower(implode(' ', $stackArr));
            $icon     = projectIcon($p['title'], $p['stack']);
            $accent   = projectAccent((int)$p['id']);
            $num      = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        ?>
        <div class="project-card" data-reveal data-tags="<?= htmlspecialchars($tagsStr) ?>">
            <div class="project-img" style="--card-accent:<?= $accent ?>">
                <div class="project-svg-icon"><?= $icon ?></div>
            </div>
            <div class="project-body">
                <div class="project-num">
                    <?= $num ?>
                    <?php if ($p['featured']): ?>
                    &mdash; <span style="color:var(--accent3)">&#9733; Featured</span>
                    <?php endif; ?>
                </div>
                <h3 class="project-title"><?= htmlspecialchars($p['title']) ?></h3>
                <p class="project-desc"><?= htmlspecialchars($p['description']) ?></p>
                <div class="project-stack">
                    <?php foreach ($stackArr as $t): ?>
                    <span class="tag"><?= htmlspecialchars($t) ?></span>
                    <?php endforeach; ?>
                </div>
                <div class="project-links">
                    <?php if (!empty($p['live_url'])): ?>
                    <a href="<?= htmlspecialchars($p['live_url']) ?>" class="project-link" target="_blank" rel="noopener">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        Live Demo
                    </a>
                    <?php else: ?>
                    <span class="project-link" style="opacity:0.35;cursor:default">Coming Soon</span>
                    <?php endif; ?>

                    <?php if (!empty($p['github_url'])): ?>
                    <a href="<?= htmlspecialchars($p['github_url']) ?>" class="project-link github" target="_blank" rel="noopener">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
                        GitHub
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<section class="section" style="text-align:center;background:var(--bg2);border-top:1px solid var(--border);">
    <div class="section-inner">
        <h2 class="section-title" data-reveal>Have a project in mind?</h2>
        <p style="color:var(--text-dim);margin-bottom:2rem;font-size:0.9rem" data-reveal>I'm always interested in exciting new challenges.</p>
        <a href="/#contact" class="btn btn-primary" data-reveal>Start a Conversation &rarr;</a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
