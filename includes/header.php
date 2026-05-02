<?php
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'DevPortfolio' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'></text></svg>">
</head>
<body>
    <div class="noise-overlay"></div>
    <div class="cursor-dot" id="cursorDot"></div>
    <div class="cursor-ring" id="cursorRing"></div>
    
    <nav class="nav" id="mainNav">
        <div class="nav-inner">
            <a href="/" class="nav-logo">
                <span class="logo-bracket">[</span>
                <span class="logo-text">chate<span class="accent">.</span>dev</span>
                <span class="logo-bracket">]</span>
            </a>
            
            <div class="nav-links">
                <a href="/" class="nav-link <?= $currentPage === 'index' ? 'active' : '' ?>">
                    <span class="link-num">01.</span> Home
                </a>
                <a href="/projects.php" class="nav-link <?= $currentPage === 'projects' ? 'active' : '' ?>">
                    <span class="link-num">02.</span> Projects
                </a>
                <a href="/blog.php" class="nav-link <?= $currentPage === 'blog' ? 'active' : '' ?>">
                    <span class="link-num">03.</span> Blog
                </a>
                <a href="/#contact" class="nav-link">
                    <span class="link-num">04.</span> Contact
                </a>
            </div>
            
            <button class="hamburger" id="hamburger" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>
    
    <div class="mobile-menu" id="mobileMenu">
        <a href="/" class="mobile-link">Home</a>
        <a href="/projects.php" class="mobile-link">Projects</a>
        <a href="/blog.php" class="mobile-link">Blog</a>
        <a href="/#contact" class="mobile-link">Contact</a>
    </div>
    
    <main class="main-content">
