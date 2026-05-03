<?php
/**
 * Returns an SVG icon string based on project title + stack keywords.
 * Falls back to a generic code icon.
 */
function projectIcon(string $title, string $stack): string
{
    $hay = strtolower($title . ' ' . $stack);

    $map = [
        // Mobile / App
        'flutter|dart|mobile|android|ios|react native|expo' =>
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18" stroke-width="2.5" stroke-linecap="round"/><path d="M9 7h6M9 11h4"/></svg>',

        // E-commerce / Store / Shop
        'ecommerce|e-commerce|shop|store|cart|woocommerce|shopify|stripe|payment' =>
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>',

        // AI / ML / OpenAI / GPT
        'ai|machine learning|openai|gpt|llm|neural|nlp|deep learning|chatbot|ml' =>
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><path d="M12 2a10 10 0 1 0 10 10"/><path d="M12 8v4l3 3"/><circle cx="19" cy="5" r="3"/></svg>',

        // Chat / Messaging / Realtime
        'chat|message|socket|websocket|realtime|real-time|discord|slack|messenger' =>
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',

        // Analytics / Dashboard / Chart / Report
        'analytics|dashboard|chart|report|statistics|metrics|data|visuali|d3|grafana' =>
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/><line x1="2" y1="20" x2="22" y2="20"/></svg>',

        // Auth / Security / Login
        'auth|login|oauth|jwt|security|password|encrypt|rbac|2fa|mfa|firewall|saml' =>
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>',

        // Task / Kanban / Project management / Todo
        'task|kanban|todo|project management|trello|jira|board|workflow|agile|scrum' =>
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><rect x="3" y="3" width="5" height="18" rx="1"/><rect x="10" y="3" width="5" height="12" rx="1"/><rect x="17" y="3" width="5" height="8" rx="1"/></svg>',

        // API / Microservice / Backend
        'api|microservice|rest|graphql|grpc|backend|fastapi|express|laravel|django' =>
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>',

        // Cloud / DevOps / Docker / Kubernetes
        'cloud|devops|docker|kubernetes|k8s|aws|azure|gcp|terraform|ci/cd|pipeline|deploy' =>
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"/></svg>',

        // Database / CMS
        'database|cms|content|mysql|postgres|mongodb|redis|sqlite|prisma|supabase' =>
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>',

        // Portfolio / Website / Landing page
        'portfolio|website|landing|blog|web|html|css|frontend|nextjs|nuxt|gatsby' =>
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>',

        // Game
        'game|gaming|unity|unreal|godot|pygame|phaser' =>
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><line x1="6" y1="12" x2="10" y2="12"/><line x1="8" y1="10" x2="8" y2="14"/><circle cx="15.5" cy="11" r="1"/><circle cx="18.5" cy="13" r="1"/><path d="M21 6H3a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1z"/></svg>',

        // Butchery / Food / Restaurant / Delivery
        'butcher|butchery|food|restaurant|delivery|order|meal|grocery|kitchen' =>
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><path d="M3 11l19-9-9 19-2-8-8-2z"/></svg>',
    ];

    foreach ($map as $pattern => $svg) {
        $parts = explode('|', $pattern);
        foreach ($parts as $keyword) {
            if (str_contains($hay, $keyword)) {
                return $svg;
            }
        }
    }

    // Generic fallback: code icon
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" width="48" height="48"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>';
}

/**
 * Pick an accent CSS var based on sort order / id (cycles through 3 colours)
 */
function projectAccent(int $id): string
{
    $accents = ['var(--accent)', 'var(--accent2)', 'var(--accent3)'];
    return $accents[$id % 3];
}
