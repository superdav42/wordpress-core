# AGENTS.md — WordPress Core (PSR Fork)

## Project Overview

Experimental fork of WordPress core modified to run as a long-running PHP process. Used by the WordPress-PSR project (request-handler + swoole) to serve WordPress via Swoole, ReactPHP, or other persistent server runtimes. Default branch is `6.9.x`.

## Build Commands

```bash
# No build step — this is WordPress core with targeted modifications
# Install via Composer as a dependency (not standalone)
```

## Key Modifications from Upstream WordPress

1. **`exit`/`die` → `wp_exit()`**: All `exit`/`die` calls replaced with `wp_exit()` which fires `do_action('wp_exit')`. The request handler catches this to return control flow instead of terminating.

2. **`header()` → action hooks**: Header calls routed through actions so the PSR response handler can capture headers and add them to the PSR-7 response object.

3. **`setcookie()` → action hooks**: Same pattern as headers — cookies captured for PSR-7 response.

4. **`require_once` → `require`**: Where appropriate, changed to allow WordPress to process multiple requests in the same process (long-running).

## Project Structure

```
wordpress-core/
├── wp-admin/           # WordPress admin
├── wp-includes/        # WordPress core libraries
├── wp-content/         # Default content directory
├── wp-settings.php     # Bootstrap (modified for re-entrant loading)
├── wp-load.php         # Loader
├── index.php           # Front controller
├── composer.json       # Provides wordpress/core-implementation 6.9.x
└── ...                 # Standard WordPress core files
```

## Code Style & Conventions

- **PHP version**: >= 8.1
- **Coding standard**: WordPress Core (same as upstream)
- **This is a Composer package** (`type: wordpress-core`)
- **Provides**: `wordpress/core-implementation: 6.9.4`
- **Modifications applied via Rector** in the `request-handler` package

## Branching

- Default branch: `6.9.x` (tracks WordPress 6.9 release line)
- Branch naming follows WordPress version: `6.8.x`, `6.9.x`, etc.
- Upstream changes merged periodically

## Important Notes

- **Do not edit WordPress core files directly** — modifications should be made via Rector transforms in the `request-handler` package when possible
- This fork exists to prove out long-running WordPress — goal is to upstream changes to WordPress core
- The `composer.json` replaces `superdav42/wordpress-core` (legacy package name)
- Used as a dependency by `wordpress-psr/request-handler` and `wordpress-psr/swoole`
