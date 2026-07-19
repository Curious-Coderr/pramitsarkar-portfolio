<?php
require_once __DIR__ . '/includes/data.php';

$slug    = isset($_GET['slug']) ? (string) $_GET['slug'] : '';
$project = find_project($slug);

if (!$project) {
    http_response_code(404);
    $pageTitle = 'Project not found — ' . $SITE['name'];
    require __DIR__ . '/includes/header.php';
    echo '<main class="container" style="padding:180px 0 120px;text-align:center;">';
    echo '<h1 class="section-heading">404 — Project not found</h1>';
    echo '<p class="section-sub" style="margin-inline:auto;">The case study you are looking for doesn&rsquo;t exist.</p>';
    echo '<p style="margin-top:2rem;"><a class="btn btn-primary" href="index.php#projects">Back to work</a></p>';
    echo '</main>';
    require __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle       = $project['title'] . ' — ' . $SITE['name'];
$pageDescription = $project['summary'];

/* Prev / next project for bottom navigation. */
$total = count($PROJECTS);
$idx   = 0;
foreach ($PROJECTS as $i => $pp) {
    if ($pp['slug'] === $project['slug']) {
        $idx = $i;
        break;
    }
}
$prevProject = $PROJECTS[($idx - 1 + $total) % $total];
$nextProject = $PROJECTS[($idx + 1) % $total];

require __DIR__ . '/includes/header.php';
?>

<div class="case-topbar">
    <div class="container">
        <a class="back-link" href="index.php#projects">
            <i data-lucide="arrow-left"></i> Back to work
        </a>
    </div>
</div>

<main class="container">
    <div class="case-main">
        <div class="case-meta">
            <span class="category-tag"><?= $project['category'] ?></span>
            <?php
                $statusClass = 'tag-muted';
                if ($project['status'] === 'Live') {
                    $statusClass = 'tag-live';
                } elseif ($project['status'] === 'In Development') {
                    $statusClass = 'tag-dev';
                } elseif ($project['status'] === 'Archived') {
                    $statusClass = 'tag-archived';
                } elseif ($project['status'] === 'Service') {
                    $statusClass = 'tag-service';
                }
            ?>
            <span class="category-tag <?= $statusClass ?>"><?= htmlspecialchars($project['status']) ?></span>
            <?php if (!empty($project['duration'])): ?>
                <span class="category-tag tag-muted"><?= htmlspecialchars($project['duration']) ?></span>
            <?php endif; ?>
        </div>

        <h1 class="case-title"><?= htmlspecialchars($project['title']) ?></h1>
        <p class="case-summary"><?= htmlspecialchars($project['summary']) ?></p>

        <?php if (!empty($project['liveUrl']) || !empty($project['githubUrl'])): ?>
            <div class="case-links">
                <?php if (!empty($project['liveUrl'])): ?>
                    <a class="btn btn-primary" href="<?= htmlspecialchars($project['liveUrl']) ?>" target="_blank" rel="noopener noreferrer">
                        View live <i data-lucide="arrow-up-right"></i>
                    </a>
                <?php endif; ?>
                <?php if (!empty($project['githubUrl'])): ?>
                    <a class="btn btn-secondary" href="<?= htmlspecialchars($project['githubUrl']) ?>" target="_blank" rel="noopener noreferrer">
                        <i data-lucide="git-fork"></i> GitHub
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="case-cover" data-category="<?= $project['category'] ?>">
            <div class="bg-blob blob-a" aria-hidden="true"></div>
            <div class="bg-blob blob-b" aria-hidden="true"></div>
            <div class="cover-window">
                <div class="window-bar"><span></span><span></span><span></span></div>
                <?php if (!empty($project['screenshots'])): ?>
                    <div class="window-body window-body--img">
                        <img
                            src="<?= htmlspecialchars($project['screenshots'][0]['src']) ?>"
                            alt="<?= htmlspecialchars($project['screenshots'][0]['alt']) ?>"
                            class="cover-screenshot"
                            style="height:280px;"
                        >
                    </div>
                <?php else: ?>
                    <div class="window-body">
                        <p class="window-title"><?= htmlspecialchars($project['title']) ?></p>
                        <p class="window-sub"><?= htmlspecialchars(implode(' · ', array_slice($project['techStack'], 0, 4))) ?></p>
                        <div class="window-flow" aria-hidden="true">
                            <span class="flow-node flow-node--start"></span>
                            <span class="flow-link"></span>
                            <span class="flow-node"></span>
                            <span class="flow-link"></span>
                            <span class="flow-node"></span>
                            <span class="flow-link"></span>
                            <span class="flow-node flow-node--end"></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($project['video']['embed'])): ?>
        <style>
        .case-video{margin:2.5rem 0;}
        .case-video h2{font-size:1rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--muted);margin-bottom:1rem;}
        .video-frame{position:relative;width:100%;padding-top:56.25%;border-radius:14px;overflow:hidden;border:1px solid var(--line);background:#000;box-shadow:var(--shadow-1);}
        .video-frame iframe{position:absolute;inset:0;width:100%;height:100%;border:0;}
        .case-video .video-note{margin-top:.7rem;font-size:.82rem;color:var(--muted);}
        .case-video .video-note a{color:inherit;text-decoration:underline;}
        </style>
        <div class="case-video">
            <h2>Video demo</h2>
            <div class="video-frame">
                <iframe
                    src="<?= htmlspecialchars($project['video']['embed']) ?>"
                    title="<?= htmlspecialchars($project['video']['title'] ?? ($project['title'] . ' — video demo')) ?>"
                    allow="autoplay; encrypted-media; picture-in-picture; fullscreen"
                    allowfullscreen
                    loading="lazy"
                ></iframe>
            </div>
            <?php $videoLink = $project['video']['link'] ?? $project['liveUrl'] ?? ''; ?>
            <?php if (!empty($videoLink)): ?>
                <p class="video-note">Video not loading? <a href="<?= htmlspecialchars($videoLink) ?>" target="_blank" rel="noopener noreferrer">Watch the demo on LinkedIn</a>.</p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($project['screenshots'])): ?>
        <style>
        .case-screenshots{margin:2.5rem 0;}
        .case-screenshots h2{font-size:1rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--muted);margin-bottom:1rem;}
        .screenshots-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(min(340px,100%),1fr));gap:1rem;}
        .screenshot-thumb{border-radius:12px;overflow:hidden;border:1px solid var(--line);cursor:zoom-in;transition:transform .25s ease,box-shadow .25s ease;background:var(--surface);}
        .screenshot-thumb:hover{transform:translateY(-3px);box-shadow:var(--shadow-2);}
        .screenshot-thumb img{width:100%;height:220px;object-fit:cover;object-position:top;display:block;transition:transform .35s ease;}
        .screenshot-thumb:hover img{transform:scale(1.03);}
        .screenshot-caption{padding:.55rem .75rem;font-size:.78rem;color:var(--muted);border-top:1px solid var(--line);}
        /* Lightbox */
        .lb-overlay{position:fixed;inset:0;background:rgba(0,0,0,.92);z-index:9999;display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity .25s;}
        .lb-overlay.open{opacity:1;pointer-events:all;}
        .lb-overlay img{max-width:92vw;max-height:90vh;border-radius:10px;box-shadow:0 32px 80px rgba(0,0,0,.7);object-fit:contain;}
        .lb-close{position:fixed;top:1.25rem;right:1.5rem;background:rgba(255,255,255,.1);border:none;border-radius:50%;width:40px;height:40px;font-size:1.3rem;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .2s;}
        .lb-close:hover{background:rgba(255,255,255,.2);}
        </style>
        <div class="case-screenshots">
            <h2>Screenshots</h2>
            <div class="screenshots-grid">
                <?php foreach ($project['screenshots'] as $shot): ?>
                <div class="screenshot-thumb" onclick="openLightbox('<?= htmlspecialchars($shot['src'], ENT_QUOTES) ?>',' <?= htmlspecialchars($shot['alt'], ENT_QUOTES) ?>')">
                    <img src="<?= htmlspecialchars($shot['src']) ?>" alt="<?= htmlspecialchars($shot['alt']) ?>" loading="lazy">
                    <div class="screenshot-caption"><?= htmlspecialchars($shot['alt']) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Lightbox overlay -->
        <div class="lb-overlay" id="lbOverlay" onclick="closeLightbox()">
            <button class="lb-close" onclick="closeLightbox()" aria-label="Close">&#x2715;</button>
            <img id="lbImg" src="" alt="">
        </div>
        <script>
        function openLightbox(src, alt){
            var o=document.getElementById('lbOverlay');
            document.getElementById('lbImg').src=src;
            document.getElementById('lbImg').alt=alt;
            o.classList.add('open');
            document.body.style.overflow='hidden';
        }
        function closeLightbox(){
            document.getElementById('lbOverlay').classList.remove('open');
            document.body.style.overflow='';
        }
        document.addEventListener('keydown',function(e){if(e.key==='Escape')closeLightbox();});
        </script>
        <?php endif; ?>

        <?php if (!empty($project['sampleData']['rows'])): ?>
        <style>
        .case-sampledata{margin:2.5rem 0;}
        .case-sampledata h2{font-size:1rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem;}
        .case-sampledata .sd-label{font-size:.9rem;color:var(--ink);margin-bottom:.15rem;font-weight:600;}
        .case-sampledata .sd-note{font-size:.82rem;color:var(--muted);margin-bottom:1rem;max-width:70ch;}
        .sd-table-wrap{overflow-x:auto;border-radius:12px;border:1px solid var(--line);background:var(--surface);box-shadow:var(--shadow-1);}
        table.sd-table{width:100%;border-collapse:collapse;font-size:.85rem;min-width:640px;}
        table.sd-table thead th{text-align:left;font-weight:600;letter-spacing:.04em;text-transform:uppercase;font-size:.72rem;color:var(--muted);padding:.8rem 1rem;background:var(--paper-2);border-bottom:1px solid var(--line-strong);white-space:nowrap;}
        table.sd-table tbody td{padding:.7rem 1rem;border-bottom:1px solid var(--line);color:var(--ink-2);vertical-align:top;}
        table.sd-table tbody tr:last-child td{border-bottom:0;}
        table.sd-table tbody tr:nth-child(even){background:var(--paper);}
        table.sd-table td.sd-mono{font-variant-numeric:tabular-nums;white-space:nowrap;color:var(--ink-2);}
        table.sd-table td.sd-name{font-weight:600;color:var(--ink);}
        table.sd-table td a{color:var(--accent);text-decoration:none;}
        table.sd-table td a:hover{text-decoration:underline;}
        table.sd-table td .sd-web{color:var(--ink-2);}
        table.sd-table td .sd-empty{color:var(--line-strong);}
        </style>
        <div class="case-sampledata">
            <h2>Sample data</h2>
            <?php if (!empty($project['sampleData']['label'])): ?>
                <p class="sd-label"><?= htmlspecialchars($project['sampleData']['label']) ?></p>
            <?php endif; ?>
            <?php if (!empty($project['sampleData']['note'])): ?>
                <p class="sd-note"><?= htmlspecialchars($project['sampleData']['note']) ?></p>
            <?php endif; ?>
            <div class="sd-table-wrap">
                <table class="sd-table">
                    <?php if (!empty($project['sampleData']['columns'])): ?>
                    <thead>
                        <tr>
                            <?php foreach ($project['sampleData']['columns'] as $col): ?>
                                <th><?= htmlspecialchars($col) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <?php endif; ?>
                    <?php
                        $sdMono = $project['sampleData']['mono'] ?? [3, 4]; // numeric columns (0-based)
                        $sdName = $project['sampleData']['nameColumn'] ?? 0; // emphasised first column
                        $sdLinks = $project['sampleData']['linkColumns'] ?? []; // website columns shown as plain (non-clickable) text
                    ?>
                    <tbody>
                        <?php foreach ($project['sampleData']['rows'] as $row): ?>
                        <tr>
                            <?php foreach ($row as $ci => $cell): ?>
                                <?php
                                    $classes = [];
                                    if (in_array($ci, $sdMono, true)) { $classes[] = 'sd-mono'; }
                                    if ($ci === $sdName) { $classes[] = 'sd-name'; }
                                    $classAttr = $classes ? ' class="' . implode(' ', $classes) . '"' : '';
                                ?>
                                <td<?= $classAttr ?>><?php
                                    if ($cell === '' || $cell === null) {
                                        echo '<span class="sd-empty">&mdash;</span>';
                                    } elseif (in_array($ci, $sdLinks, true) && preg_match('#^https?://#i', $cell)) {
                                        // Website shown as plain, non-clickable text — no outbound (do-follow) backlink.
                                        $label = preg_replace('#^https?://(www\.)?#i', '', rtrim($cell, '/'));
                                        echo '<span class="sd-web">' . htmlspecialchars($label) . '</span>';
                                    } else {
                                        echo htmlspecialchars($cell);
                                    }
                                ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <div class="case-body">
            <div class="case-content">
                <section>
                    <div class="case-sec-head"><span class="case-sec-num">01</span><h2>The problem</h2></div>
                    <p><?= htmlspecialchars($project['problem']) ?></p>
                </section>
                <section>
                    <div class="case-sec-head"><span class="case-sec-num">02</span><h2>The solution</h2></div>
                    <p><?= htmlspecialchars($project['solution']) ?></p>
                </section>
                <section>
                    <div class="case-sec-head"><span class="case-sec-num">03</span><h2>Key features</h2></div>
                    <ul class="feature-list">
                        <?php foreach ($project['features'] as $f): ?>
                            <li><i data-lucide="check-circle"></i><?= htmlspecialchars($f) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </section>
                <?php if (!empty($project['results'])): ?>
                    <section>
                        <div class="case-sec-head"><span class="case-sec-num">04</span><h2>Results</h2></div>
                        <p><?= htmlspecialchars($project['results']) ?></p>
                    </section>
                <?php endif; ?>
            </div>

            <aside class="case-sidebar">
                <div class="info-card">
                    <p class="eyebrow">My role</p>
                    <p class="val"><?= htmlspecialchars($project['role']) ?></p>
                </div>
                <div class="info-card">
                    <p class="eyebrow">Tech stack</p>
                    <div class="tech-pills">
                        <?php foreach ($project['techStack'] as $t): ?>
                            <span class="tech-pill"><?= htmlspecialchars($t) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php if (!empty($project['client'])): ?>
                    <div class="info-card">
                        <p class="eyebrow">Client</p>
                        <p class="val"><?= htmlspecialchars($project['client']) ?></p>
                    </div>
                <?php endif; ?>
            </aside>
        </div>

        <nav class="case-nav" aria-label="More projects">
            <a href="project.php?slug=<?= urlencode($prevProject['slug']) ?>" class="prev">
                <span class="dir"><i data-lucide="arrow-left"></i> Previous project</span>
                <span class="t"><?= htmlspecialchars($prevProject['title']) ?></span>
            </a>
            <a href="project.php?slug=<?= urlencode($nextProject['slug']) ?>" class="next">
                <span class="dir">Next project <i data-lucide="arrow-right"></i></span>
                <span class="t"><?= htmlspecialchars($nextProject['title']) ?></span>
            </a>
        </nav>

        <div class="case-final-cta">
            <h3>Have a similar problem?</h3>
            <p>Let&rsquo;s talk about what you&rsquo;re trying to build.</p>
            <a class="btn btn-primary" href="index.php#contact">Start a conversation</a>
        </div>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
