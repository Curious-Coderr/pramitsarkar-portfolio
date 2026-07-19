<?php
require_once __DIR__ . '/includes/data.php';

$pageTitle       = 'All Projects — ' . $SITE['name'];
$pageDescription = 'The complete portfolio of ' . $SITE['name'] . ' — websites, ecommerce stores, AI systems and automations built for businesses across industries.';

require __DIR__ . '/includes/header.php';
?>

<div class="case-topbar">
    <div class="container">
        <a class="back-link" href="index.php#projects">
            <i data-lucide="arrow-left"></i> Back to home
        </a>
    </div>
</div>

<main class="container">
    <div class="case-main">
        <div class="section-head reveal">
            <p class="eyebrow"><span class="eyebrow-num">All</span> Work</p>
            <h2 class="section-heading">Every project I&rsquo;ve <span class="serif">shipped.</span></h2>
            <p class="section-sub">The complete portfolio — from flagship builds to smaller sites and services, live and archived. Filter by category below.</p>
        </div>

        <div class="filter-tabs reveal" id="filterTabs">
            <?php foreach ($PROJECT_CATEGORIES as $i => $cat): ?>
                <button class="filter-tab<?= $i === 0 ? ' active' : '' ?>" data-filter="<?= $cat ?>"><?= $cat ?></button>
            <?php endforeach; ?>
        </div>

        <div class="projects-grid reveal stagger" id="projectsGrid">
            <?php foreach ($PROJECTS as $p): ?>
                <article class="project-card" data-category="<?= $p['category'] ?>">
                    <a class="project-cover" href="project.php?slug=<?= urlencode($p['slug']) ?>" aria-label="<?= htmlspecialchars($p['title']) ?> case study">
                        <div class="cover-window">
                            <div class="window-bar"><span></span><span></span><span></span></div>
                            <?php if (!empty($p['screenshots'])): ?>
                                <div class="window-body window-body--img">
                                    <img
                                        src="<?= htmlspecialchars($p['screenshots'][0]['src']) ?>"
                                        alt="<?= htmlspecialchars($p['screenshots'][0]['alt']) ?>"
                                        loading="lazy"
                                        class="cover-screenshot"
                                    >
                                </div>
                            <?php else: ?>
                                <div class="window-body">
                                    <p class="window-title"><?= htmlspecialchars($p['title']) ?></p>
                                    <p class="window-sub"><?= htmlspecialchars(implode(' · ', array_slice($p['techStack'], 0, 3))) ?></p>
                                    <div class="window-flow" aria-hidden="true">
                                        <span class="flow-node flow-node--start"></span>
                                        <span class="flow-link"></span>
                                        <span class="flow-node"></span>
                                        <span class="flow-link"></span>
                                        <span class="flow-node flow-node--end"></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="project-tags">
                            <span class="category-tag"><?= $p['category'] ?></span>
                            <?php if ($p['status'] === 'Live'): ?>
                                <span class="category-tag tag-live">Live</span>
                            <?php elseif ($p['status'] === 'In Development'): ?>
                                <span class="category-tag tag-dev">In Development</span>
                            <?php elseif ($p['status'] === 'Archived'): ?>
                                <span class="category-tag tag-archived">Archived</span>
                            <?php elseif ($p['status'] === 'Service'): ?>
                                <span class="category-tag tag-service">Service</span>
                            <?php endif; ?>
                        </div>
                    </a>
                    <div class="project-body">
                        <h3><?= htmlspecialchars($p['title']) ?></h3>
                        <p class="summary"><?= htmlspecialchars($p['summary']) ?></p>
                        <div class="project-tech">
                            <?php foreach (array_slice($p['techStack'], 0, 4) as $t): ?>
                                <span class="tech-pill"><?= htmlspecialchars($t) ?></span>
                            <?php endforeach; ?>
                            <?php if (count($p['techStack']) > 4): ?>
                                <span class="tech-pill">+<?= count($p['techStack']) - 4 ?></span>
                            <?php endif; ?>
                        </div>
                        <a class="case-link" href="project.php?slug=<?= urlencode($p['slug']) ?>">
                            View case study <i data-lucide="arrow-up-right"></i>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="case-final-cta">
            <h3>Have a similar problem?</h3>
            <p>Let&rsquo;s talk about what you&rsquo;re trying to build.</p>
            <a class="btn btn-primary" href="index.php#contact">Start a conversation</a>
        </div>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
