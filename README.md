# Pramit Sarkar — Portfolio

Personal portfolio website for **Pramit Sarkar**, AI & Automation Engineer.
Built with PHP (server-side includes, pretty-URL routing, and a contact form).

## Tech

- PHP 8.2 + Apache (`.htaccess` rewrites)
- Vanilla HTML/CSS/JS (`assets/`)
- Contact form (`contact.php`) with email + log fallback

## Run locally

```bash
php -S localhost:8000
```

Then open http://localhost:8000

## Deploy

Deployed as a Docker web service (see `Dockerfile` and `render.yaml`).

Environment variables:

- `CONTACT_EMAIL` — inbox that receives contact-form submissions
