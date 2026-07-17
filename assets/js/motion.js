/* ═══════════════════════════════════════════════════
   Pramit Sarkar — AI Solutions Agency
   Motion layer (progressive enhancement)
   Powered by Motion (motion.dev) — the vanilla-JS engine
   from the Framer Motion creators, loaded via CDN.

   This file is additive: every effect is wrapped so a
   single failure never blocks the others, and the site
   remains fully usable if Motion fails to load.
═══════════════════════════════════════════════════ */

const REDUCED = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
const FINE_POINTER = window.matchMedia("(pointer: fine)").matches;
const EASE = [0.16, 1, 0.3, 1];

/* Safely run a feature without letting it crash the rest. */
function safe(label, fn) {
  try { fn(); } catch (err) { console.warn("[motion] " + label + " skipped:", err); }
}

(async function boot() {
  let M = null;
  try {
    M = await import("https://cdn.jsdelivr.net/npm/motion@11/+esm");
  } catch (err) {
    console.warn("[motion] Motion library failed to load — using baseline experience.", err);
  }

  const root = document.documentElement;
  root.classList.add("motion-on");
  if (M) root.classList.add("motion-ready");

  const animate = M && M.animate;
  const inView = M && M.inView;
  const scroll = M && M.scroll;
  const stagger = M && M.stagger;

  /* ───────── Scroll progress bar ───────── */
  safe("scroll-progress", () => {
    const bar = document.getElementById("scrollProgress");
    if (!bar) return;
    if (M && scroll && animate) {
      scroll(animate(bar, { scaleX: [0, 1] }, { ease: "linear" }));
    } else {
      const onScroll = () => {
        const h = document.documentElement;
        const p = h.scrollTop / ((h.scrollHeight - h.clientHeight) || 1);
        bar.style.transform = "scaleX(" + Math.min(1, Math.max(0, p)) + ")";
      };
      window.addEventListener("scroll", onScroll, { passive: true });
      onScroll();
    }
  });

  /* ───────── Word-by-word heading reveals ───────── */
  safe("text-reveal", () => {
    if (REDUCED || !M || !animate || !inView) return;

    const collectWords = (node, out) => {
      Array.from(node.childNodes).forEach((child) => {
        if (child.nodeType === 3) {
          const parts = child.textContent.split(/(\s+)/);
          if (parts.length === 0) return;
          const frag = document.createDocumentFragment();
          parts.forEach((part) => {
            if (part === "") return;
            if (/^\s+$/.test(part)) { frag.appendChild(document.createTextNode(part)); return; }
            const word = document.createElement("span");
            word.className = "reveal-word";
            const inner = document.createElement("span");
            inner.className = "reveal-word-i";
            inner.textContent = part;
            inner.style.transform = "translateY(110%)";
            inner.style.opacity = "0";
            word.appendChild(inner);
            frag.appendChild(word);
            out.push(inner);
          });
          node.replaceChild(frag, child);
        } else if (child.nodeType === 1) {
          collectWords(child, out);
        }
      });
    };

    document.querySelectorAll(".section-heading, .cta-band h2").forEach((heading) => {
      const words = [];
      collectWords(heading, words);
      if (!words.length) return;
      heading.classList.add("is-split");
      inView(heading, () => {
        animate(
          words,
          { transform: ["translateY(110%)", "translateY(0%)"], opacity: [0, 1] },
          { delay: stagger(0.035), duration: 0.7, ease: EASE }
        );
      }, { amount: 0.35 });
    });
  });

  /* ───────── Extra flourish on scroll-reveal blocks ───────── */
  safe("reveal-pop", () => {
    if (REDUCED || !M || !animate || !inView) return;
    // Takes over the CSS ".stagger" rise (disabled via .motion-ready) with a
    // bolder, spring-flavoured pop for every staggered grid on the page.
    document.querySelectorAll(".stagger").forEach((grid) => {
      const items = Array.from(grid.children);
      if (!items.length) return;
      items.forEach((el) => {
        el.style.willChange = "transform, opacity";
        el.style.opacity = "0";
      });
      // Trigger as soon as any part of the grid enters the viewport. A fixed
      // fraction (e.g. 0.15) can never be reached when the grid is taller than
      // the viewport — which left long grids (like the projects grid) stuck at
      // opacity:0. "some" fires reliably regardless of grid height.
      inView(grid, () => {
        animate(
          items,
          { opacity: [0, 1], transform: ["translateY(24px) scale(0.96)", "translateY(0) scale(1)"] },
          { delay: stagger(0.06), duration: 0.6, ease: EASE }
        );
      }, { amount: "some" });
    });
  });

  /* ───────── Magnetic buttons ───────── */
  safe("magnetic", () => {
    if (REDUCED || !FINE_POINTER) return;
    document.querySelectorAll(".btn, .nav-cta").forEach((el) => {
      el.classList.add("magnetic");
      const strength = 0.35;
      el.addEventListener("pointermove", (e) => {
        const r = el.getBoundingClientRect();
        const x = (e.clientX - (r.left + r.width / 2)) * strength;
        const y = (e.clientY - (r.top + r.height / 2)) * strength;
        el.style.transform = "translate(" + x + "px," + y + "px)";
      });
      el.addEventListener("pointerleave", () => { el.style.transform = ""; });
    });
  });

  /* ───────── 3D tilt on cards ───────── */
  safe("tilt", () => {
    if (REDUCED || !FINE_POINTER) return;
    const MAX = 9; // degrees
    document.querySelectorAll(".project-card, .service-card, .tech-card").forEach((card) => {
      card.classList.add("tilt");
      card.addEventListener("pointermove", (e) => {
        const r = card.getBoundingClientRect();
        const px = (e.clientX - r.left) / r.width - 0.5;
        const py = (e.clientY - r.top) / r.height - 0.5;
        card.style.transform =
          "perspective(900px) rotateX(" + (-py * MAX) + "deg) rotateY(" + (px * MAX) +
          "deg) translateY(-6px)";
      });
      card.addEventListener("pointerleave", () => { card.style.transform = ""; });
    });
  });

  /* ───────── Cursor spotlight glow on cards ───────── */
  safe("card-spotlight", () => {
    if (REDUCED || !FINE_POINTER) return;
    document.querySelectorAll(".project-card, .service-card, .tech-card").forEach((card) => {
      const glow = document.createElement("span");
      glow.className = "card-glow";
      glow.setAttribute("aria-hidden", "true");
      card.appendChild(glow);
      card.addEventListener("pointermove", (e) => {
        const r = card.getBoundingClientRect();
        glow.style.setProperty("--gx", (e.clientX - r.left) + "px");
        glow.style.setProperty("--gy", (e.clientY - r.top) + "px");
      });
      card.addEventListener("pointerenter", () => glow.classList.add("on"));
      card.addEventListener("pointerleave", () => glow.classList.remove("on"));
    });
  });

  /* ───────── Custom cursor ───────── */
  safe("cursor", () => {
    if (REDUCED || !FINE_POINTER) return;
    const dot = document.createElement("div");
    dot.className = "cursor-dot";
    const ring = document.createElement("div");
    ring.className = "cursor-ring";
    document.body.appendChild(dot);
    document.body.appendChild(ring);
    document.body.classList.add("has-cursor");

    let mx = window.innerWidth / 2, my = window.innerHeight / 2;
    let rx = mx, ry = my;
    window.addEventListener("pointermove", (e) => {
      mx = e.clientX; my = e.clientY;
      dot.style.transform = "translate(" + mx + "px," + my + "px)";
    }, { passive: true });

    const loop = () => {
      rx += (mx - rx) * 0.18;
      ry += (my - ry) * 0.18;
      ring.style.transform = "translate(" + rx + "px," + ry + "px)";
      requestAnimationFrame(loop);
    };
    requestAnimationFrame(loop);

    const interactive = "a, button, .filter-tab, .faq-q, input, select, textarea, .project-card, .service-card";
    document.addEventListener("pointerover", (e) => {
      if (e.target.closest(interactive)) ring.classList.add("is-hover");
    });
    document.addEventListener("pointerout", (e) => {
      if (e.target.closest(interactive)) ring.classList.remove("is-hover");
    });
    document.addEventListener("pointerdown", () => ring.classList.add("is-down"));
    document.addEventListener("pointerup", () => ring.classList.remove("is-down"));
    document.addEventListener("mouseleave", () => { dot.style.opacity = "0"; ring.style.opacity = "0"; });
    document.addEventListener("mouseenter", () => { dot.style.opacity = ""; ring.style.opacity = ""; });
  });

  /* ───────── Interactive hero particle field ───────── */
  safe("particles", () => {
    if (REDUCED) return;
    const hero = document.querySelector(".hero");
    if (!hero) return;

    const canvas = document.createElement("canvas");
    canvas.className = "hero-particles";
    canvas.setAttribute("aria-hidden", "true");
    hero.insertBefore(canvas, hero.firstChild);
    const ctx = canvas.getContext("2d");
    if (!ctx) return;

    let W = 0, H = 0, dpr = Math.min(window.devicePixelRatio || 1, 2);
    let particles = [];
    const mouse = { x: -9999, y: -9999 };

    const rgb = "37, 69, 232"; // accent
    const density = 0.00009; // particles per px²

    const resize = () => {
      const r = hero.getBoundingClientRect();
      W = r.width; H = r.height;
      canvas.width = W * dpr; canvas.height = H * dpr;
      canvas.style.width = W + "px"; canvas.style.height = H + "px";
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
      const count = Math.max(28, Math.min(90, Math.round(W * H * density)));
      particles = new Array(count).fill(0).map(() => ({
        x: Math.random() * W,
        y: Math.random() * H,
        vx: (Math.random() - 0.5) * 0.35,
        vy: (Math.random() - 0.5) * 0.35,
        r: Math.random() * 1.8 + 0.8,
      }));
    };

    hero.addEventListener("pointermove", (e) => {
      const r = hero.getBoundingClientRect();
      mouse.x = e.clientX - r.left;
      mouse.y = e.clientY - r.top;
    });
    hero.addEventListener("pointerleave", () => { mouse.x = -9999; mouse.y = -9999; });

    const LINK = 128;
    const tick = () => {
      ctx.clearRect(0, 0, W, H);
      for (let i = 0; i < particles.length; i++) {
        const p = particles[i];
        // mouse repulsion
        const dxm = p.x - mouse.x, dym = p.y - mouse.y;
        const dm = Math.hypot(dxm, dym);
        if (dm < 140 && dm > 0) {
          const f = (140 - dm) / 140 * 0.9;
          p.vx += (dxm / dm) * f;
          p.vy += (dym / dm) * f;
        }
        p.x += p.vx; p.y += p.vy;
        p.vx *= 0.96; p.vy *= 0.96;
        // gentle base drift so they never fully stop
        if (Math.abs(p.vx) < 0.05) p.vx += (Math.random() - 0.5) * 0.1;
        if (Math.abs(p.vy) < 0.05) p.vy += (Math.random() - 0.5) * 0.1;
        if (p.x < 0) p.x = W; else if (p.x > W) p.x = 0;
        if (p.y < 0) p.y = H; else if (p.y > H) p.y = 0;

        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fillStyle = "rgba(" + rgb + ",0.55)";
        ctx.fill();

        for (let j = i + 1; j < particles.length; j++) {
          const q = particles[j];
          const dx = p.x - q.x, dy = p.y - q.y;
          const d = Math.hypot(dx, dy);
          if (d < LINK) {
            ctx.beginPath();
            ctx.moveTo(p.x, p.y);
            ctx.lineTo(q.x, q.y);
            ctx.strokeStyle = "rgba(" + rgb + "," + (0.18 * (1 - d / LINK)) + ")";
            ctx.lineWidth = 1;
            ctx.stroke();
          }
        }
      }
      raf = requestAnimationFrame(tick);
    };

    let raf = 0;
    resize();
    tick();
    window.addEventListener("resize", () => {
      dpr = Math.min(window.devicePixelRatio || 1, 2);
      resize();
    });

    // Pause when the hero scrolls out of view to save battery.
    if ("IntersectionObserver" in window) {
      const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) { if (!raf) tick(); }
          else { cancelAnimationFrame(raf); raf = 0; }
        });
      }, { threshold: 0 });
      io.observe(hero);
    }
  });

  /* ───────── Smooth page-exit transition ───────── */
  safe("page-transition", () => {
    if (REDUCED) return;
    const veil = document.createElement("div");
    veil.className = "page-veil";
    veil.setAttribute("aria-hidden", "true");
    document.body.appendChild(veil);

    document.addEventListener("click", (e) => {
      const a = e.target.closest("a[href]");
      if (!a) return;
      if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
      if (a.target === "_blank" || a.hasAttribute("download")) return;
      let url;
      try { url = new URL(a.href, location.href); } catch (_) { return; }
      if (url.origin !== location.origin) return;                 // external
      if (url.pathname === location.pathname) return;             // same page (incl. hash nav)
      e.preventDefault();
      root.classList.add("is-leaving");
      window.setTimeout(() => { window.location.href = url.href; }, 360);
    });

    // Fade back in if the page is restored from the bfcache.
    window.addEventListener("pageshow", (ev) => {
      if (ev.persisted) root.classList.remove("is-leaving");
    });
  });
})();
