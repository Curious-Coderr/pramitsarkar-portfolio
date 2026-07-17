<?php require __DIR__ . '/includes/header.php'; ?>

<main>
    <!-- ═══════════ HERO ═══════════ -->
    <section id="hero" class="hero">
        <div class="hero-bg" aria-hidden="true"></div>
        <div class="bg-blob blob-a" aria-hidden="true"></div>
        <div class="bg-blob blob-b" aria-hidden="true"></div>
        <div class="bg-blob blob-c" aria-hidden="true"></div>

        <div class="container hero-inner">
            <div class="hero-copy reveal">
                <a href="#contact" class="hero-badge js-nav">
                    <span class="badge-dot"></span> Available for new projects
                </a>
                <h1 class="hero-title" aria-label="AI systems, automations and software that do the work for you.">
                    <span aria-hidden="true">AI systems, automations &amp; software that
                        <span class="type-line"><span class="serif" id="typeTarget" data-phrases='["do the work for you.","run while you sleep.","never miss a lead.","scale your business."]'>do the work for you.</span><span class="type-cursor" aria-hidden="true"></span></span>
                    </span>
                </h1>
                <p class="hero-sub">
                    I design and build AI agents, automation pipelines, CRMs, and custom software
                    that remove manual work from your business — scoped honestly, shipped fast,
                    and fully owned by you.
                </p>
                <div class="hero-cta">
                    <a href="#projects" class="btn btn-primary js-nav">
                        See my work <i data-lucide="arrow-down"></i>
                    </a>
                    <a href="<?= htmlspecialchars($SITE['calendly']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">
                        Book a discovery call <i data-lucide="arrow-up-right"></i>
                    </a>
                </div>
                <div class="hero-meta">
                    <img src="pramit.png" alt="" width="28" height="28">
                    <span><?= htmlspecialchars($SITE['name']) ?> &middot; AI &amp; Automation Engineer &middot; Working globally</span>
                </div>
            </div>

            <div class="trust-bar reveal">
                <p class="trust-label">Building with</p>
                <div class="marquee">
                    <div class="marquee-track">
                        <?php foreach ($TECH_LOGOS as $tech): ?>
                            <span class="marquee-item">
                                <span class="marquee-logo"><?= render_svg_logo($tech['logo'], 'currentColor') ?></span>
                                <?= htmlspecialchars($tech['name']) ?>
                            </span>
                        <?php endforeach; ?>
                        <?php foreach ($TECH_LOGOS as $tech): ?>
                            <span class="marquee-item" aria-hidden="true">
                                <span class="marquee-logo"><?= render_svg_logo($tech['logo'], 'currentColor') ?></span>
                                <?= htmlspecialchars($tech['name']) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <a href="#stats" class="scroll-cue js-nav" id="scrollCue" aria-label="Scroll to explore">
            <span class="cue-track"><span class="cue-dot"></span></span>
            <span class="cue-text">Scroll</span>
        </a>
    </section>

    <!-- ═══════════ STATS ═══════════ -->
    <section id="stats" class="section tight">
        <div class="container">
            <div class="stats-band reveal">
                <?php foreach ($STATS as $s): ?>
                    <div class="stat">
                        <div class="stat-num" data-count="<?= $s['value'] ?>" data-suffix="<?= htmlspecialchars($s['suffix']) ?>"><?= $s['value'] . $s['suffix'] ?></div>
                        <div class="stat-label"><?= htmlspecialchars($s['label']) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ═══════════ ABOUT ═══════════ -->
    <section id="about" class="section">
        <div class="container">
            <div class="about-grid">
                <div class="about-photo reveal">
                    <figure class="photo-card">
                        <img src="pramit.png" alt="<?= htmlspecialchars($SITE['name']) ?>, AI &amp; Automation Engineer">
                    </figure>
                    <div class="photo-caption">
                        <span class="ping"><span class="wave"></span><span class="dot"></span></span>
                        <span>Available for new projects &mdash; typically 2&ndash;4 week onboarding</span>
                    </div>
                </div>

                <div class="about-text reveal">
                    <p class="eyebrow"><span class="eyebrow-num">01</span> About</p>
                    <h2 class="section-heading">
                        I build systems, <span class="serif">not just websites.</span>
                    </h2>
                    <p>
                        Most agencies sell you a website. I build the intelligent infrastructure behind it —
                        AI agents that qualify leads, automation pipelines that replace manual work, CRM systems
                        that give you full visibility into your business, and software that scales without
                        scaling your headcount.
                    </p>
                    <p>
                        I&rsquo;ve spent years at the intersection of operations and technology, building
                        independent AI and automation systems for businesses across healthcare, real estate,
                        legal, and ecommerce verticals.
                    </p>
                    <p>
                        My clients are business owners who are done with fragile integrations and expensive
                        SaaS tools that don&rsquo;t talk to each other. They want a partner who understands their
                        operations and builds something that actually runs.
                    </p>

                    <div class="about-creds">
                        <?php foreach ($CREDENTIALS as $c): ?>
                            <div class="about-cred">
                                <span class="cred-icon"><i data-lucide="<?= $c['icon'] ?>"></i></span>
                                <span><?= htmlspecialchars($c['text']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <p class="panel-label">Industries I work in</p>
                    <div class="industry-tags">
                        <?php foreach ($ABOUT_INDUSTRIES as $ind): ?>
                            <span class="industry-tag">
                                <i data-lucide="<?= $ind['icon'] ?>"></i><?= htmlspecialchars($ind['name']) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════ SERVICES ═══════════ -->
    <section id="services" class="section surface line-top line-bottom section-canvas">
        <div class="container">
            <div class="section-head reveal">
                <p class="eyebrow"><span class="eyebrow-num">02</span> What I build</p>
                <h2 class="section-heading">Services that <span class="serif">move the needle.</span></h2>
                <p class="section-sub">
                    Not a menu to choose from — a set of capabilities I combine to solve the actual
                    problem your business has.
                </p>
            </div>

            <div class="services-grid reveal stagger">
                <?php foreach ($SERVICES as $i => $s): ?>
                    <div class="service-card<?= $i < 2 ? ' service-card--featured' : '' ?>">
                        <div class="service-top">
                            <span class="service-num"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                            <span class="service-icon"><i data-lucide="<?= $s['icon'] ?>"></i></span>
                        </div>
                        <h3><?= htmlspecialchars($s['title']) ?></h3>
                        <p><?= htmlspecialchars($s['description']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ═══════════ PROJECTS ═══════════ -->
    <section id="projects" class="section">
        <div class="container">
            <div class="section-head reveal">
                <p class="eyebrow"><span class="eyebrow-num">03</span> Featured work</p>
                <h2 class="section-heading">Systems I&rsquo;ve <span class="serif">shipped.</span></h2>
                <p class="section-sub">A few flagship builds. Real projects, honest descriptions, no inflated metrics.</p>
            </div>

            <div class="projects-grid reveal stagger" id="projectsGrid">
                <?php foreach (get_featured_projects() as $p): ?>
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

            <div class="projects-more reveal">
                <a class="btn btn-secondary" href="projects.php">
                    See more projects <i data-lucide="arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ═══════════ PROCESS ═══════════ -->
    <section id="process" class="section surface line-top line-bottom section-canvas">
        <div class="container">
            <div class="section-head reveal">
                <p class="eyebrow"><span class="eyebrow-num">04</span> How it works</p>
                <h2 class="section-heading">A process built for <span class="serif">real outcomes.</span></h2>
            </div>

            <div class="process-list reveal">
                <?php foreach ($PROCESS as $step): ?>
                    <div class="process-row">
                        <span class="process-num"><?= $step['number'] ?></span>
                        <h3><?= htmlspecialchars($step['title']) ?></h3>
                        <p><?= htmlspecialchars($step['description']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ═══════════ TECH STACK ═══════════ -->
    <section id="tech-stack" class="section">
        <div class="container">
            <div class="section-head reveal">
                <p class="eyebrow"><span class="eyebrow-num">05</span> Stack</p>
                <h2 class="section-heading">The tools behind <span class="serif">the systems.</span></h2>
                <p class="section-sub">What I use to design, build, automate, and ship — across AI, code, and infrastructure.</p>
            </div>

            <div class="tech-stack reveal stagger">
                <?php foreach ($TECH_STACK as $group): ?>
                    <div class="tech-card">
                        <div class="tech-card-head">
                            <h3 class="tech-group-title"><?= htmlspecialchars($group['category']) ?></h3>
                            <span class="tech-count"><?= count($group['items']) ?></span>
                        </div>
                        <div class="tech-logos">
                            <?php foreach ($group['items'] as $t): ?>
                                <div class="tech-chip" style="--brand: <?= $t['color'] ?>;">
                                    <span class="tech-logo"><?= render_svg_logo($t['logo'], 'currentColor') ?></span>
                                    <span class="tech-name"><?= htmlspecialchars($t['name']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ═══════════ INDUSTRIES ═══════════ -->
    <section id="industries" class="section surface line-top line-bottom">
        <div class="container">
            <div class="section-head center reveal">
                <p class="eyebrow"><span class="eyebrow-num">06</span> Industries</p>
                <h2 class="section-heading">Businesses I&rsquo;ve <span class="serif">served.</span></h2>
            </div>

            <div class="industry-pills reveal stagger">
                <?php foreach ($INDUSTRIES as $industry): ?>
                    <span class="industry-pill"><?= htmlspecialchars($industry) ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ═══════════ FAQ ═══════════ -->
    <section id="faq" class="section">
        <div class="container">
            <div class="section-head center reveal">
                <p class="eyebrow"><span class="eyebrow-num">07</span> FAQ</p>
                <h2 class="section-heading">Questions I get <span class="serif">asked.</span></h2>
            </div>

            <div class="faq-list reveal" id="faqList">
                <?php foreach ($FAQS as $i => $faq): ?>
                    <div class="faq-item<?= $i === 0 ? ' open' : '' ?>">
                        <button class="faq-q" aria-expanded="<?= $i === 0 ? 'true' : 'false' ?>">
                            <span><?= htmlspecialchars($faq['q']) ?></span>
                            <i data-lucide="chevron-down"></i>
                        </button>
                        <div class="faq-a">
                            <p><?= htmlspecialchars($faq['a']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ═══════════ CTA BAND ═══════════ -->
    <section class="cta-band">
        <div class="bg-blob blob-a" aria-hidden="true"></div>
        <div class="bg-blob blob-b" aria-hidden="true"></div>
        <div class="container">
            <div class="cta-inner reveal">
                <p class="eyebrow eyebrow-light"><span class="eyebrow-num">Next</span> Step</p>
                <h2>Let&rsquo;s build something that <span class="serif">actually ships.</span></h2>
                <p>Book a free discovery call or send a message below. I&rsquo;ll come back within 24 hours with honest thoughts on what&rsquo;s possible.</p>
                <div class="cta-actions">
                    <a href="<?= htmlspecialchars($SITE['calendly']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-paper btn-lg">
                        <i data-lucide="calendar-days"></i> Book a discovery call
                    </a>
                    <a href="#contact" class="btn btn-outline-light btn-lg js-nav">
                        <i data-lucide="mail"></i> Send a message
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════ CONTACT ═══════════ -->
    <section id="contact" class="section">
        <div class="bg-blob blob-b" aria-hidden="true"></div>
        <div class="container">
            <div class="section-head reveal">
                <p class="eyebrow"><span class="eyebrow-num">08</span> Get in touch</p>
                <h2 class="section-heading">Tell me what you&rsquo;re <span class="serif">working on.</span></h2>
                <p class="section-sub">
                    I&rsquo;ll come back within 24 hours with honest thoughts on what&rsquo;s possible
                    and how I&rsquo;d approach it.
                </p>
            </div>

            <div class="contact-grid reveal">
                <form class="contact-form" id="contactForm" novalidate>
                    <div class="form-row">
                        <div class="field">
                            <label for="name">Full name *</label>
                            <input id="name" name="name" type="text" placeholder="John Smith" required>
                        </div>
                        <div class="field">
                            <label for="email">Email *</label>
                            <input id="email" name="email" type="email" placeholder="john@company.com" required>
                        </div>
                    </div>

                    <div class="field">
                        <label for="company">Company / business</label>
                        <input id="company" name="company" type="text" placeholder="Your company name">
                    </div>

                    <div class="form-row">
                        <div class="field">
                            <label for="projectType">Project type *</label>
                            <select id="projectType" name="projectType" required>
                                <option value="">Select type</option>
                                <?php foreach ($PROJECT_TYPES as $t): ?>
                                    <option value="<?= htmlspecialchars($t) ?>"><?= htmlspecialchars($t) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="field">
                            <label for="budget">Budget range *</label>
                            <select id="budget" name="budget" required>
                                <option value="">Select range</option>
                                <?php foreach ($BUDGET_RANGES as $b): ?>
                                    <option value="<?= htmlspecialchars($b) ?>"><?= htmlspecialchars($b) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="field">
                        <label for="message">Tell me about your project *</label>
                        <textarea id="message" name="message" rows="5" placeholder="What problem are you trying to solve? What does success look like?" required></textarea>
                    </div>

                    <div class="form-alert" id="formSuccess" role="status" aria-live="polite" hidden>
                        <i data-lucide="check-circle"></i>
                        <span>Message sent! I&rsquo;ll be in touch within 24 hours.</span>
                    </div>
                    <div class="form-alert" id="formError" role="alert" aria-live="assertive" hidden>
                        <i data-lucide="alert-circle"></i>
                        <span>Something went wrong. Please email me directly.</span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block" id="submitBtn">
                        <i data-lucide="send"></i> <span>Send message</span>
                    </button>
                </form>

                <div class="contact-side">
                    <p class="side-title">Or reach out directly</p>
                    <?php foreach ($CONTACT_LINKS as $c): ?>
                        <a class="contact-link" href="<?= htmlspecialchars($c['href']) ?>" target="_blank" rel="noopener noreferrer">
                            <span class="ic">
                                <?php if (!empty($c['logo'])): ?>
                                    <?= render_svg_logo($c['logo'], 'currentColor', 'social') ?>
                                <?php else: ?>
                                    <i data-lucide="<?= $c['icon'] ?>"></i>
                                <?php endif; ?>
                            </span>
                            <span>
                                <span class="label"><?= htmlspecialchars($c['label']) ?></span>
                                <span class="sub"><?= htmlspecialchars($c['sub']) ?></span>
                            </span>
                        </a>
                    <?php endforeach; ?>

                    <figure class="contact-photo">
                        <figcaption class="cp-cap">
                            <strong><?= htmlspecialchars($SITE['name']) ?></strong>
                            <span>AI &amp; Automation Engineer &mdash; here to help</span>
                        </figcaption>
                        <img src="pramit%202.png" alt="<?= htmlspecialchars($SITE['name']) ?>, AI &amp; Automation Engineer" width="408" height="402" loading="lazy">
                    </figure>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
