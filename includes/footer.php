<?php
/** Shared footer + closing scripts. */
require_once __DIR__ . '/data.php';
$year = date('Y');
?>
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-about">
                <div class="footer-brand">
                    <img src="pramit.png" alt="" width="38" height="38">
                    <span class="logo-text"><?= htmlspecialchars($SITE['name']) ?></span>
                </div>
                <p class="blurb">
                    AI solutions studio. Building intelligent systems that save businesses time,
                    cut costs, and increase revenue. Based in India, working globally.
                </p>
            </div>

            <div class="footer-col">
                <p class="eyebrow">Navigation</p>
                <ul>
                    <?php foreach ($FOOTER_NAV as $link): ?>
                        <li><a class="js-nav" href="index.php<?= $link['href'] ?>"><?= htmlspecialchars($link['label']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="footer-col footer-social">
                <p class="eyebrow">Connect</p>
                <ul>
                    <?php foreach ($SOCIAL_LINKS as $s): ?>
                        <li>
                            <a href="<?= htmlspecialchars($s['href']) ?>" target="_blank" rel="noopener noreferrer">
                                <?php if (!empty($s['logo'])): ?>
                                    <span class="soc-ic"><?= render_svg_logo($s['logo'], 'currentColor', 'social') ?></span>
                                <?php else: ?>
                                    <i data-lucide="<?= $s['icon'] ?>"></i>
                                <?php endif; ?><?= htmlspecialchars($s['label']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <p class="footer-word" aria-hidden="true">PRAMIT SARKAR</p>

        <div class="footer-bottom">
            <p>&copy; <?= $year ?> <?= htmlspecialchars($SITE['name']) ?>. All rights reserved.</p>
            <p>Designed &amp; built by hand — PHP &middot; CSS &middot; JavaScript</p>
        </div>
    </div>
</footer>

<button class="scroll-top" id="scrollTop" aria-label="Scroll back to top">
    <svg class="st-ring" viewBox="0 0 48 48" aria-hidden="true">
        <circle class="st-track" cx="24" cy="24" r="22"></circle>
        <circle class="st-bar" id="scrollTopBar" cx="24" cy="24" r="22"></circle>
    </svg>
    <i data-lucide="arrow-up"></i>
</button>

<!-- Toast notifications (copy confirmations, etc.) -->
<div class="toast-stack" id="toastStack" aria-live="polite"></div>

<script src="assets/js/main.js"></script>
<script type="module" src="assets/js/motion.js"></script>
<script>
    if (window.lucide) { lucide.createIcons(); }
</script>
</body>
</html>
