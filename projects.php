<?php
$pageTitle = 'Projects — DevPortfolio';
require_once __DIR__ . '/includes/header.php';

$projects = [
    [
        'num' => '01',
        'emoji' => '🛒',
        'title' => 'E-Commerce Platform',
        'desc' => 'Full-featured multi-tenant e-commerce platform with real-time inventory, payment processing, and a powerful merchant dashboard.',
        'stack' => ['PHP', 'Laravel', 'MySQL', 'Vue.js', 'Stripe', 'Redis'],
        'live' => 'http://willowsadventures.store/',
        'github' => '#',
        'tags' => 'php laravel vue mysql saas',
        'featured' => true
    ],
    [
        'num' => '02',
        'emoji' => '💬',
        'title' => 'Ecommerce Butchery App',
        'desc' => 'WebSocket-powered chat backend with rooms, private messaging, file sharing, and end-to-end encryption support.',
        'stack' => ['Flutter', 'Socket.io', 'PostgreSQL', 'Redis', 'Docker'],
        'live' => '#',
        'github' => '#',
        'tags' => 'nodejs api docker postgresql',
        'featured' => false
    ],
    [
        'num' => '03',
        'emoji' => '💬',
        'title' => 'Real-time Chat API',
        'desc' => 'WebSocket-powered chat backend with rooms, private messaging, file sharing, and end-to-end encryption support.',
        'stack' => ['Node.js', 'Socket.io', 'PostgreSQL', 'Redis', 'Docker'],
        'live' => '#',
        'github' => '#',
        'tags' => 'nodejs api docker postgresql',
        'featured' => false
    ],
    [
        'num' => '04',
        'emoji' => '📊',
        'title' => 'Analytics Dashboard',
        'desc' => 'Interactive data visualization dashboard with custom charting, multi-source data ingestion, and exportable reports.',
        'stack' => ['React', 'TypeScript', 'D3.js', 'PHP', 'MySQL'],
        'live' => '#',
        'github' => '#',
        'tags' => 'react typescript php mysql',
        'featured' => true
    ],
    [
        'num' => '05',
        'emoji' => '🤖',
        'title' => 'AI Content Pipeline',
        'desc' => 'Automated content generation and publishing pipeline integrating OpenAI GPT, content scheduling, and SEO analysis.',
        'stack' => ['Python', 'FastAPI', 'OpenAI', 'PostgreSQL', 'React'],
        'live' => '#',
        'github' => '#',
        'tags' => 'python api react ai postgresql',
        'featured' => false
    ],
    [
        'num' => '06',
        'emoji' => '🔐',
        'title' => 'Auth Microservice',
        'desc' => 'Production-ready authentication microservice with OAuth 2.0, JWT, MFA, RBAC, and full audit logging.',
        'stack' => ['PHP', 'JWT', 'OAuth2', 'MySQL', 'Docker'],
        'live' => '#',
        'github' => '#',
        'tags' => 'php docker mysql security',
        'featured' => false
    ],
    [
        'num' => '07',
        'emoji' => '📱',
        'title' => 'Task Manager App',
        'desc' => 'Productivity app with Kanban boards, team collaboration, time tracking, and native mobile experience via PWA.',
        'stack' => ['Vue.js', 'Laravel', 'MySQL', 'Pusher', 'PWA'],
        'live' => '#',
        'github' => '#',
        'tags' => 'vue laravel php mysql',
        'featured' => true
    ],
];

$techs = ['all', 'php', 'react', 'vue', 'nodejs', 'docker', 'python', 'mysql'];
?>

<section class="page-hero">
    <div class="page-hero-inner">
        <p class="section-tag" style="margin-bottom:1rem" data-reveal>My Work</p>
        <h1 class="page-hero-title" data-reveal>
            Selected <span class="accent">Projects</span>
        </h1>
        <p class="page-hero-sub" data-reveal>
            A curated collection of things I've built — from SaaS platforms to open source tools.
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
        <div class="project-img">
            <span><?= $project['emoji'] ?></span>
        </div>
        <div class="project-body">
            <div class="project-num"><?= $project['num'] ?> <?= $project['featured'] ? '— <span style="color:var(--accent3)">★ Featured</span>' : '' ?></div>
            <h3 class="project-title"><?= htmlspecialchars($project['title']) ?></h3>
            <p class="project-desc"><?= htmlspecialchars($project['desc']) ?></p>
            <div class="project-stack">
                <?php foreach ($project['stack'] as $tech): ?>
                <span class="tag"><?= $tech ?></span>
                <?php endforeach; ?>
            </div>
            <div class="project-links">
                <a href="<?= $project['live'] ?>" class="project-link" target="_blank">
                    ↗ Live Demo
                </a>
                <a href="<?= $project['github'] ?>" class="project-link github" target="_blank">
                    ⌥ GitHub
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
        <a href="/#contact" class="btn btn-primary" data-reveal>Start a Conversation →</a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
