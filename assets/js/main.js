/* ═══════════════════════════════════════════════════
   Pramit Sarkar — AI Solutions Agency
   Front-end behaviour (vanilla JS)
═══════════════════════════════════════════════════ */
(function () {
  "use strict";

  const prefersReduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  /* ---------- Intro loader (baseline dismissal, works without Motion) ---------- */
  const rootEl = document.documentElement;
  if (rootEl.classList.contains("is-loading")) {
    const loader = document.getElementById("siteLoader");
    const start = performance.now();
    const MIN = prefersReduced ? 0 : 650;
    const done = () => {
      if (!rootEl.classList.contains("is-loading")) return;
      rootEl.classList.remove("is-loading");
      try { sessionStorage.setItem("ps-visited", "1"); } catch (e) {}
      if (loader) window.setTimeout(() => loader.remove(), 700);
    };
    const finish = () => window.setTimeout(done, Math.max(0, MIN - (performance.now() - start)));
    if (document.readyState === "complete") finish();
    else window.addEventListener("load", finish);
    window.setTimeout(done, 4500); // hard safety cap
  }

  /* ---------- Navbar scroll state ---------- */
  const navbar = document.getElementById("navbar");
  const onScroll = () => {
    if (!navbar) return;
    navbar.classList.toggle("scrolled", window.scrollY > 50);
  };
  window.addEventListener("scroll", onScroll, { passive: true });
  onScroll();

  /* ---------- Mobile menu ---------- */
  const navToggle = document.getElementById("navToggle");
  const mobileMenu = document.getElementById("mobileMenu");
  if (navToggle && mobileMenu) {
    navToggle.addEventListener("click", () => {
      const open = mobileMenu.classList.toggle("open");
      navToggle.innerHTML = open ? '<i data-lucide="x"></i>' : '<i data-lucide="menu"></i>';
      if (window.lucide) lucide.createIcons();
    });
  }

  /* ---------- Smooth in-page scrolling for hash links ---------- */
  const closeMobile = () => {
    if (mobileMenu && mobileMenu.classList.contains("open")) {
      mobileMenu.classList.remove("open");
      if (navToggle) {
        navToggle.innerHTML = '<i data-lucide="menu"></i>';
        if (window.lucide) lucide.createIcons();
      }
    }
  };

  document.querySelectorAll(".js-nav").forEach((link) => {
    link.addEventListener("click", (e) => {
      const href = link.getAttribute("href") || "";
      const hashIndex = href.indexOf("#");
      if (hashIndex === -1) return;
      const id = href.slice(hashIndex + 1);
      const target = document.getElementById(id);
      // Only intercept when the target exists on the current page.
      if (target) {
        e.preventDefault();
        closeMobile();
        target.scrollIntoView({ behavior: prefersReduced ? "auto" : "smooth", block: "start" });
        history.replaceState(null, "", "#" + id);
      }
    });
  });

  /* ---------- Project filtering ---------- */
  const filterTabs = document.getElementById("filterTabs");
  const projectCards = Array.from(document.querySelectorAll("#projectsGrid .project-card"));
  if (filterTabs) {
    filterTabs.addEventListener("click", (e) => {
      const btn = e.target.closest(".filter-tab");
      if (!btn) return;
      filterTabs.querySelectorAll(".filter-tab").forEach((t) => t.classList.remove("active"));
      btn.classList.add("active");
      const filter = btn.getAttribute("data-filter");
      projectCards.forEach((card) => {
        const match = filter === "All" || card.getAttribute("data-category") === filter;
        card.classList.toggle("hidden", !match);
      });
    });
  }

  /* ---------- FAQ accordion ---------- */
  const faqList = document.getElementById("faqList");
  if (faqList) {
    const setHeight = (item) => {
      const ans = item.querySelector(".faq-a");
      if (!ans) return;
      ans.style.maxHeight = item.classList.contains("open") ? ans.scrollHeight + "px" : "0px";
    };
    faqList.querySelectorAll(".faq-item").forEach((item) => setHeight(item));

    faqList.addEventListener("click", (e) => {
      const q = e.target.closest(".faq-q");
      if (!q) return;
      const item = q.closest(".faq-item");
      const wasOpen = item.classList.contains("open");
      faqList.querySelectorAll(".faq-item").forEach((other) => {
        if (other !== item) {
          other.classList.remove("open");
          const btn = other.querySelector(".faq-q");
          if (btn) btn.setAttribute("aria-expanded", "false");
          setHeight(other);
        }
      });
      item.classList.toggle("open", !wasOpen);
      q.setAttribute("aria-expanded", String(!wasOpen));
      setHeight(item);
    });

    window.addEventListener("resize", () => {
      faqList.querySelectorAll(".faq-item.open").forEach((item) => setHeight(item));
    });
  }

  /* ---------- Contact form (AJAX to contact.php) ---------- */
  const form = document.getElementById("contactForm");
  if (form) {
    const submitBtn = document.getElementById("submitBtn");
    const btnLabel = submitBtn ? submitBtn.querySelector("span") : null;
    const successBox = document.getElementById("formSuccess");
    const errorBox = document.getElementById("formError");

    const hideAlert = (box) => {
      if (!box) return;
      box.classList.remove("success", "error");
      box.hidden = true;
    };
    const showAlert = (box, cls) => {
      if (!box) return;
      box.hidden = false;
      box.classList.add(cls);
    };

    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      hideAlert(successBox);
      hideAlert(errorBox);

      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }

      const payload = {
        name: form.name.value,
        email: form.email.value,
        company: form.company.value,
        projectType: form.projectType.value,
        budget: form.budget.value,
        message: form.message.value,
      };

      if (submitBtn) submitBtn.disabled = true;
      if (btnLabel) btnLabel.textContent = "Sending...";

      try {
        const res = await fetch("contact.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(payload),
        });
        if (res.ok) {
          showAlert(successBox, "success");
          form.reset();
        } else {
          showAlert(errorBox, "error");
        }
      } catch (err) {
        showAlert(errorBox, "error");
      } finally {
        if (submitBtn) submitBtn.disabled = false;
        if (btnLabel) btnLabel.textContent = "Send Message";
      }
    });
  }

  /* ---------- Scroll reveal ---------- */
  const revealEls = document.querySelectorAll(".reveal");
  if (prefersReduced || !("IntersectionObserver" in window)) {
    revealEls.forEach((el) => el.classList.add("in-view"));
  } else {
    const io = new IntersectionObserver(
      (entries, obs) => {
        entries.forEach((entry) => {
          // Reveal once 12% of the element is visible, OR — for elements that
          // are taller than the viewport (e.g. a long projects grid) where 12%
          // can never be reached — as soon as any part scrolls into view.
          const vh = window.innerHeight || document.documentElement.clientHeight;
          const tallerThanViewport = entry.boundingClientRect.height > vh;
          if (entry.isIntersecting && (entry.intersectionRatio >= 0.12 || tallerThanViewport)) {
            entry.target.classList.add("in-view");
            obs.unobserve(entry.target);
          }
        });
      },
      { threshold: [0, 0.12], rootMargin: "0px 0px -40px 0px" }
    );
    revealEls.forEach((el) => io.observe(el));
  }

  /* ---------- Scroll-to-top button (with progress ring) ---------- */
  const scrollTopBtn = document.getElementById("scrollTop");
  if (scrollTopBtn) {
    const bar = document.getElementById("scrollTopBar");
    const CIRC = 138.2; // 2·π·22
    const toggleTop = () => {
      const doc = document.documentElement;
      const max = (doc.scrollHeight - doc.clientHeight) || 1;
      const p = Math.min(1, Math.max(0, window.scrollY / max));
      scrollTopBtn.classList.toggle("show", window.scrollY > 600);
      if (bar) bar.style.strokeDashoffset = String(CIRC * (1 - p));
    };
    window.addEventListener("scroll", toggleTop, { passive: true });
    window.addEventListener("resize", toggleTop, { passive: true });
    toggleTop();
    scrollTopBtn.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: prefersReduced ? "auto" : "smooth" });
    });
  }

  /* ---------- Scroll-spy: highlight the active section in the nav ---------- */
  const spyLinks = Array.from(document.querySelectorAll('.nav-link, .mobile-menu a'))
    .map((link) => {
      const href = link.getAttribute("href") || "";
      const hash = href.indexOf("#");
      if (hash === -1) return null;
      const section = document.getElementById(href.slice(hash + 1));
      return section ? { link, section } : null;
    })
    .filter(Boolean);

  if (spyLinks.length) {
    let activeId = null;
    const spy = () => {
      const line = window.scrollY + 140; // account for the fixed navbar
      let current = spyLinks[0];
      for (const entry of spyLinks) {
        if (entry.section.offsetTop <= line) current = entry;
      }
      // If we're near the very bottom, force-select the last section.
      const doc = document.documentElement;
      if (window.scrollY + doc.clientHeight >= doc.scrollHeight - 4) {
        current = spyLinks[spyLinks.length - 1];
      }
      const id = current.section.id;
      if (id === activeId) return;
      activeId = id;
      spyLinks.forEach((e) => e.link.classList.toggle("active", e.section.id === id));
    };
    window.addEventListener("scroll", spy, { passive: true });
    window.addEventListener("resize", spy, { passive: true });
    spy();
  }

  /* ---------- Hero scroll cue (fades out once you start scrolling) ---------- */
  const scrollCue = document.getElementById("scrollCue");
  if (scrollCue) {
    const hideCue = () => scrollCue.classList.toggle("hide", window.scrollY > 80);
    window.addEventListener("scroll", hideCue, { passive: true });
    hideCue();
  }

  /* ---------- Toast + copy-to-clipboard on email links ---------- */
  const toastStack = document.getElementById("toastStack");
  const showToast = (text) => {
    if (!toastStack) return;
    const t = document.createElement("div");
    t.className = "toast";
    t.innerHTML = '<i data-lucide="check"></i><span></span>';
    t.querySelector("span").textContent = text;
    toastStack.appendChild(t);
    if (window.lucide) lucide.createIcons();
    requestAnimationFrame(() => requestAnimationFrame(() => t.classList.add("show")));
    setTimeout(() => {
      t.classList.remove("show");
      setTimeout(() => t.remove(), 400);
    }, 2200);
  };

  document.querySelectorAll('a[href^="mailto:"]').forEach((link) => {
    link.addEventListener("click", () => {
      const email = (link.getAttribute("href") || "").replace(/^mailto:/, "").split("?")[0];
      if (!email || !navigator.clipboard) return;
      // Copy silently; the mail client still opens (default not prevented).
      navigator.clipboard.writeText(email).then(
        () => showToast("Email copied to clipboard"),
        () => {}
      );
    });
  });

  /* ---------- Hero typewriter ---------- */
  const typeEl = document.getElementById("typeTarget");
  if (typeEl && !prefersReduced) {
    let phrases = [];
    try {
      phrases = JSON.parse(typeEl.getAttribute("data-phrases") || "[]");
    } catch (err) {
      phrases = [];
    }
    if (phrases.length > 1) {
      const TYPE_MS = 55;
      const DELETE_MS = 28;
      const HOLD_MS = 2300;
      const START_MS = 2600;
      let pi = 0;
      let ci = phrases[0].length;
      let deleting = true;

      const tick = () => {
        const phrase = phrases[pi];
        if (deleting) {
          ci--;
          typeEl.textContent = phrase.slice(0, ci);
          if (ci === 0) {
            deleting = false;
            pi = (pi + 1) % phrases.length;
          }
          setTimeout(tick, DELETE_MS);
        } else {
          ci++;
          typeEl.textContent = phrases[pi].slice(0, ci);
          if (ci === phrases[pi].length) {
            deleting = true;
            setTimeout(tick, HOLD_MS);
          } else {
            setTimeout(tick, TYPE_MS);
          }
        }
      };
      setTimeout(tick, START_MS);
    }
  }

  /* ---------- Stat count-up ---------- */
  const statEls = Array.from(document.querySelectorAll(".stat-num[data-count]"));
  if (statEls.length) {
    const runCount = (el) => {
      const target = parseFloat(el.getAttribute("data-count")) || 0;
      const suffix = el.getAttribute("data-suffix") || "";
      if (prefersReduced) {
        el.textContent = target + suffix;
        return;
      }
      const duration = 1400;
      const start = performance.now();
      const tick = (now) => {
        const p = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - p, 3);
        el.textContent = Math.round(target * eased) + suffix;
        if (p < 1) requestAnimationFrame(tick);
      };
      requestAnimationFrame(tick);
    };

    if (!("IntersectionObserver" in window)) {
      statEls.forEach(runCount);
    } else {
      const statIO = new IntersectionObserver(
        (entries, obs) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              runCount(entry.target);
              obs.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.5 }
      );
      statEls.forEach((el) => statIO.observe(el));
    }
  }

})();
