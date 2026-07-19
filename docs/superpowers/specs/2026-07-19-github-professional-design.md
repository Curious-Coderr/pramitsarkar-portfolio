# Spec: Make the portfolio repo "professional" for GitHub

## Goal
Improve the repository's presentation and structure for public open-source standards,
focusing on documentation and repository hygiene. The live site code and all real
content/branding (Pramit Sarkar, projects, links, images) remain unchanged.

## Scope
In scope:
- Rewrite `README.md` into a proper project README (badges, features, structure, setup, deploy, env vars, license).
- Add `LICENSE` (MIT, Pramit Sarkar, 2026).
- Clean up and comment `.gitignore` (ignore OS/editor junk, logs, env, vendor, and the local `linkedin projects/` working folder).
- Add `.editorconfig` for consistent contributor style.
- Add a minimal `CONTRIBUTING.md`.

Out of scope:
- Any changes to the working site (PHP/HTML/CSS/JS).
- Restructuring into a `public/` directory (would break the existing Dockerfile).
- CI/CD workflows.

## Files to create / modify
1. `README.md` — full rewrite.
2. `LICENSE` — new MIT license file.
3. `.gitignore` — expand with comments + ignore `linkedin projects/`.
4. `.editorconfig` — new, PHP/JS/HTML/CSS/Markdown settings.
5. `CONTRIBUTING.md` — new, lightweight.

## Acceptance
- Repo has a clear README, license, and contributor guidance.
- `linkedin projects/` (local working folder) is git-ignored and not committed.
- No site behavior changes.
