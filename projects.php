<?php
$pageTitle = 'Projects — Chate Billy Chilima';
require_once __DIR__ . '/includes/header.php';

// SVG icons for each project (inline, no emojis)
$icons = [
    'cart'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>',
    'mobile'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18" stroke-width="2.5" stroke-linecap="round"/><path d="M9 7h6M9 11h4"/></svg>',
    'chat'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
    'chart'   => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/><line x1="2" y1="20" x2="22" y2="20"/></svg>',
    'ai'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><path d="M12 2a10 10 0 1 0 10 10"/><path d="M12 8v4l3 3"/><circle cx="19" cy="5" r="3"/></svg>',
    'lock'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>',
    'kanban'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><rect x="3" y="3" width="5" height="18" rx="1"/><rect x="10" y="3" width="5" height="12" rx="1"/><rect x="17" y="3" width="5" height="8" rx="1"/></svg>',
];

$projects = [
    [
        'num'      => '01',
        'icon'     => $icons['cart'],
        'title'    => 'E-Commerce Platform',
        'desc'     => 'Full-featured multi-tenant e-commerce platform with real-time inventory, payment processing, and a powerful merchant dashboard.',
        'stack'    => ['PHP', 'Laravel', 'MySQL', 'Vue.js', 'Stripe', 'Redis'],
        'live'     => 'http://willowsadventures.store/',
        'github'   => '#',
        'tags'     => 'php laravel vue mysql saas',
        'featured' => true,
        'accent'   => 'var(--accent)',
    ],
    [
        'num'      => '02',
        'icon'     => $icons['mobile'],
        'title'    => 'Butchery Ordering App',
        'desc'     => 'A cross-platform mobile app that lets customers browse cuts, place orders, schedule deliveries, and pay seamlessly. Built for a local butchery to modernise their sales and inventory workflow.',
        'stack'    => ['Flutter', 'Dart', 'Firebase', 'Node.js', 'PostgreSQL'],
        'live'     => '#',
        'github'   => '#',
        'tags'     => 'flutter dart mobile firebase nodejs',
        'featured' => true,
        'accent'   => 'var(--accent2)',
    ],
    [
        'num'      => '03',
        'icon'     => $icons['chat'],
        'title'    => 'Real-time Chat API',
        'desc'     => 'WebSocket-powered chat backend with rooms, private messaging, file sharing, and end-to-end encryption support.',
        'stack'    => ['Node.js', 'Socket.io', 'PostgreSQL', 'Redis', 'Docker'],
        'live'     => '#',
        'github'   => '#',
        'tags'     => 'nodejs api docker postgresql',
        'featured' => false,
        'accent'   => 'var(--accent)',
    ],
    [
        'num'      => '04',
        'icon'     => $icons['chart'],
        'title'    => 'Analytics Dashboard',
        'desc'     => 'Interactive data visualization dashboard with custom charting, multi-source data ingestion, and exportable reports.',
        'stack'    => ['React', 'TypeScript', 'D3.js', 'PHP', 'MySQL'],
        'live'     => '#',
        'github'   => '#',
        'tags'     => 'react typescript php mysql',
        'featured' => true,
        'accent'   => 'var(--accent2)',
    ],
    [
        'num'      => '05',
        'icon'     => $icons['ai'],
        'title'    => 'AI Content Pipeline',
        'desc'     => 'Automated content generation and publishing pipeline integrating OpenAI GPT, content scheduling, and SEO analysis.',
        'stack'    => ['Python', 'FastAPI', 'OpenAI', 'PostgreSQL', 'React'],
        'live'     => '#',
        'github'   => '#',
        'tags'     => 'python api react ai postgresql',
        'featured' => false,
        'accent'   => 'var(--accent)',
    ],
    [
        'num'      => '06',
        'icon'     => $icons['lock'],
        'title'    => 'Auth Microservice',
        'desc'     => 'Production-ready authentication microservice with OAuth 2.0, JWT, MFA, RBAC, and full audit logging.',
        'stack'    => ['PHP', 'JWT', 'OAuth2', 'MySQL', 'Docker'],
        'live'     => '#',
        'github'   => '#',
        'tags'     => 'php docker mysql security',
        'featured' => false,
        'accent'   => 'var(--accent3)',
    ],
    [
        'num'      => '07',
        'icon'     => $icons['kanban'],
        'title'    => 'Task Manager App',
        'desc'     => 'Productivity app with Kanban boards, team collaboration, time tracking, and native mobile experience via PWA.',
        'stack'    => ['Vue.js', 'Laravel', 'MySQL', 'Pusher', 'PWA'],
        'live'     => '#',
        'github'   => '#',
        'tags'     => 'vue laravel php mysql',
        'featured' => true,
        'accent'   => 'var(--accent2)',
    ],
];

$techs = ['all', 'php', 'flutter', 'react', 'vue', 'nodejs', 'docker', 'python', 'mysql'];
?>

<section class="page-hero">
    <div class="page-hero-inner">
        <p class="section-tag" style="margin-bottom:1rem" data-reveal>My Work</p>
        <h1 class="page-hero-title" data-reveal>
            Selected <span class="accent">Projects</span>
        </h1>
        <p class="page-hero-sub" data-reveal>
            A curated collection of things I've built — from SaaS platforms to mobile apps.
        </p>
    </div>
</section>

<div class="filter-bar">
    <div class="inner">
        <?php foreach ($techs as $tech): ?>
        <button
            class="filter-btn <?= $tech === 'all' ? 'active' : '' ?>"
            data-filter="<?= $tech ?>">
            <?= $tech === 'all' ? 'All Projects' : strtoupper($tech) ?>
        </button>
        <?php endforeach; ?>
    </div>
</div>

<div class="projects-grid" style="max-width:1200px;margin:0 auto;">
    <?php foreach ($projects as $project): ?>
    <div class="project-card" data-reveal data-tags="<?= $project['tags'] ?>">
        <div class="project-img" style="--card-accent: <?= $project['accent'] ?>">
            <div class="project-svg-icon">
                <?= $project['icon'] ?>
            </div>
        </div>
        <div class="project-body">
            <div class="project-num">
                <?= $project['num'] ?>
                <?php if ($project['featured']): ?>
                &mdash; <span style="color:var(--accent3)">&#9733; Featured</span>
                <?php endif; ?>
            </div>
            <h3 class="project-title"><?= htmlspecialchars($project['title']) ?></h3>
            <p class="project-desc"><?= htmlspecialchars($project['desc']) ?></p>
            <div class="project-stack">
                <?php foreach ($project['stack'] as $tech): ?>
                <span class="tag"><?= htmlspecialchars($tech) ?></span>
                <?php endforeach; ?>
            </div>
            <div class="project-links">
                <?php if ($project['live'] !== '#'): ?>
                <a href="<?= $project['live'] ?>" class="project-link" target="_blank">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    Live Demo
                </a>
                <?php else: ?>
                <span class="project-link" style="opacity:0.35;cursor:default">Coming Soon</span>
                <?php endif; ?>
                <a href="<?= $project['github'] ?>" class="project-link github" target="_blank">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
                    GitHub
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- CTA -->
<section class="section" style="text-align:center;background:var(--bg2);border-top:1px solid var(--border);">
    <div class="section-inner">
        <h2 class="section-title" data-reveal>Have a project in mind?</h2>
        <p style="color:var(--text-dim);margin-bottom:2rem;font-size:0.9rem" data-reveal>
            I'm always interested in exciting new challenges.
        </p>
        <a href="/#contact" class="btn btn-primary" data-reveal>Start a Conversation &rarr;</a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
