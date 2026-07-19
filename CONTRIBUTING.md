# Contributing

Thanks for your interest in this project! This is a personal portfolio site,
but clean, well-scoped contributions are welcome.

## How to contribute

1. **Fork** the repo and create a branch from `main`:
   ```bash
   git checkout -b fix/short-description
   ```
2. **Set up locally** (PHP 8.2+):
   ```bash
   php -S localhost:8000
   ```
3. **Make your change.** Keep edits focused and avoid unrelated refactoring.
4. **Follow the existing style** — see [`.editorconfig`](.editorconfig).
   - PHP: 4-space indent, `<?php` tag, `htmlspecialchars()` on all output.
   - All site content lives in [`includes/data.php`](includes/data.php).
5. **Open a pull request** describing the change and why it's needed.

## Reporting issues

Open an issue with: what you expected, what happened, and steps to reproduce.
For security concerns, please email the maintainer directly rather than opening
a public issue.

## Code of Conduct

Be respectful and constructive. Harassment or abusive behavior will not be
tolerated.
