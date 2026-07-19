# Pramit Sarkar — Portfolio

[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![Deploy: Render](https://img.shields.io/badge/Deployed%20on-Render-46E3B7?logo=render&logoColor=white)](https://render.com/)

A personal portfolio website for **Pramit Sarkar**, an AI & Automation Engineer.
It presents services, featured case studies, a tech stack, and a working contact
form — built as a lightweight PHP site with no framework and no build step.

> Live site: **https://pramitsarkar-ai.onrender.com**

---

## Features

- **Single-page experience** with smooth in-page navigation (Hero, About, Services,
  Work, Process, Tech Stack, Industries, FAQ, Contact).
- **Case-study pages** (`/projects/{slug}`) with problem / solution / features /
  results, screenshots, and video embeds.
- **Featured + full project listings** driven by a single content array in PHP.
- **Working contact form** (`contact.php`) with email delivery (Resend + `mail()`
  fallback) and a local log fallback.
- **Pretty URLs** via Apache `.htaccess` rewrites (optional; plain links also work).
- **Dockerised** for deployment (PHP 8.2 + Apache) — ships a `Dockerfile` and
  `render.yaml`.

## Tech stack

- **Backend:** PHP 8.2 (server-side includes, no framework)
- **Frontend:** Vanilla HTML, CSS, JavaScript (no bundler)
- **Icons:** [Lucide](https://lucide.dev/) (CDN)
- **Server:** Apache with `mod_rewrite`
- **Deploy:** Docker → Render (free plan)

## Project structure

```
.
├── index.php            # Home (single-page site)
├── projects.php         # Full project listing with category filter
├── project.php          # Individual case study (?slug=...)
├── contact.php          # Contact form handler (JSON + form POST)
├── ping.php             # Lightweight uptime/health endpoint
├── sitemap.php          # Dynamic XML sitemap
├── robots.txt
├── .htaccess            # Pretty-URL rewrites + asset caching
├── Dockerfile           # PHP 8.2 + Apache image
├── render.yaml          # Render deploy config
├── includes/
│   ├── header.php       # <head> + navbar (shared)
│   ├── footer.php       # footer + scripts (shared)
│   └── data.php         # All site content (single source of truth)
└── assets/
    ├── css/             # Stylesheet(s)
    ├── js/              # main.js + motion.js
    ├── img/             # SVG brand logos (tech/social) + project screenshots
    └── favicon.svg
```

All editable content (services, projects, stats, FAQ, contact options) lives in
[`includes/data.php`](includes/data.php) — change the arrays there to update the site.

## Local development

Requires PHP 8.2+ (the built-in server is enough for local preview):

```bash
php -S localhost:8000
```

Then open <http://localhost:8000>.

> The contact form writes submissions to `contact-submissions.log` as a fallback.
> Email delivery is enabled by setting the environment variables below.

## Environment variables

| Variable         | Purpose                                                       |
| ---------------- | ------------------------------------------------------------- |
| `CONTACT_EMAIL`  | Inbox that receives contact-form submissions.                 |
| `RESEND_API_KEY` | Resend API key for transactional email (preferred delivery). |
| `RESEND_FROM`    | Verified sender address for Resend, e.g. `Name <x@resend.dev>`. |

On hosts where `mail()` is unavailable (e.g. Render), the Resend API is used.
If neither is configured, submissions are still saved to the local log file.

## Deployment

The site is containerised and deployed as a Docker web service.

1. Build the image from `Dockerfile` (PHP 8.2 + Apache, `mod_rewrite` enabled).
2. Set the environment variables above.
3. `render.yaml` wires this up for [Render](https://render.com/) on the free plan.

Any host that runs Apache + PHP 8.2 and honours `.htaccess` will also work.

## License

Released under the [MIT License](LICENSE). © 2026 Pramit Sarkar.
