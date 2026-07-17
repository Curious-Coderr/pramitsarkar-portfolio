<?php
/**
 * Shared <head> + navbar.
 * Optional vars a page may set before including this file:
 *   $pageTitle, $pageDescription
 */
require_once __DIR__ . '/data.php';

$metaTitle = $pageTitle ?? $SITE['title'];
$metaDesc  = $pageDescription ?? $SITE['description'];

// Initials for the intro loader mark (e.g. "Pramit Sarkar" -> "PS")
// Uses plain string functions so it works without the mbstring extension.
$nameParts = preg_split('/\s+/', trim($SITE['name']));
$initials  = '';
foreach ($nameParts as $part) {
    if ($part !== '') { $initials .= strtoupper(substr($part, 0, 1)); }
}
$initials = $initials !== '' ? substr($initials, 0, 2) : 'PS';
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <script>
        // Progressive-enhancement flags set as early as possible to avoid FOUC.
        (function () {
            var h = document.documentElement;
            h.className = h.className.replace('no-js', 'js');
            var seen = false;
            try { seen = sessionStorage.getItem('ps-visited') === '1'; } catch (e) {}
            if (!seen) { h.classList.add('is-loading'); }
        })();
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($metaTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($metaDesc) ?>">
    <meta name="author" content="Pramit Sarkar">
    <meta name="keywords" content="AI Solutions Agency, AI Automation, AI Chatbot, CRM Development, Business Automation, n8n automation, Pramit Sarkar">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= htmlspecialchars($SITE['url']) ?>">
    <meta property="og:site_name" content="<?= htmlspecialchars($SITE['title']) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($metaTitle) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($metaDesc) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($metaTitle) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($metaDesc) ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Inter+Tight:wght@400;500;600;700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">

    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Icons (Lucide) -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

<!-- Scroll progress indicator (driven by Motion) -->
<div class="scroll-progress" id="scrollProgress" aria-hidden="true"></div>

<!-- Branded intro loader (first visit per session) -->
<div class="site-loader" id="siteLoader" role="presentation" aria-hidden="true">
    <div class="loader-inner">
        <span class="loader-mark"><?= htmlspecialchars($initials) ?></span>
        <span class="loader-name"><?= htmlspecialchars($SITE['name']) ?></span>
        <span class="loader-bar"><span class="loader-bar-fill"></span></span>
    </div>
</div>

<header class="navbar" id="navbar">
    <nav class="nav-shell">
        <a href="index.php" class="nav-logo">
            <img src="pramit.png" alt="<?= htmlspecialchars($SITE['name']) ?>" class="nav-avatar" width="32" height="32">
            <span class="logo-text"><?= htmlspecialchars($SITE['name']) ?></span>
        </a>

        <ul class="nav-links">
            <?php foreach ($NAV_LINKS as $link): ?>
                <li><a class="nav-link js-nav" href="index.php<?= $link['href'] ?>"><?= htmlspecialchars($link['label']) ?></a></li>
            <?php endforeach; ?>
        </ul>

        <a class="nav-cta js-nav" href="index.php#contact">Book a call</a>

        <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">
            <i data-lucide="menu"></i>
        </button>
    </nav>

    <div class="mobile-menu" id="mobileMenu">
        <ul>
            <?php foreach ($NAV_LINKS as $link): ?>
                <li><a class="js-nav" href="index.php<?= $link['href'] ?>"><?= htmlspecialchars($link['label']) ?></a></li>
            <?php endforeach; ?>
            <li><a class="nav-cta js-nav" href="index.php#contact">Book a call</a></li>
        </ul>
    </div>
</header>
