# CLAUDE.md

This file provides guidance for AI coding assistants when working with code in this repository.

## Project Overview

This is a WordPress theme that uses Vite for asset bundling, Tailwind CSS v4 for styling, and Blade for templating. The theme is designed for minimal complexity with optimized asset handling.

## Development Commands

- `npm run dev` - Start Vite development server with HMR (clears manifest before starting)
- `npm run build` - Build production assets with Vite
- `npm run lint` - Run PHPCS, PHPStan, and Stylelint together
- `npm run lint:php` - Check PHP against PSR-12 coding standards
- `npm run lint:php:fix` - Auto-fix PHPCS violations
- `npm run lint:types` - Run PHPStan static analysis (level 5)
- `npm run lint:css` - Check CSS with Stylelint
- `npm run lint:css:fix` - Auto-fix Stylelint violations
- `npm run typecheck` - Run TypeScript type checking
- `npm run bundle` - Lint + build + create production zip
- `npm run bundle:quick` - Build + zip (skip linting)
- `npm run bundle:clean` - Remove the bundled/ directory

## Blade Templating

The theme uses [jenssegers/blade](https://github.com/jenssegers/blade) (standalone Laravel Blade) for templating.

### How It Works
- `ViteStarterTheme\Blade` singleton in `inc/Blade.php` initializes the engine
- Views live in `resources/views/` with `.blade.php` extension
- Compiled cache goes to `storage/views/` (gitignored)
- Root PHP files (`index.php`) delegate to Blade via `Blade::view('index')`
- `header.php`/`footer.php` are empty stubs — the layout handles the HTML document

### Custom Directives
- `@wphead` — calls `wp_head()`
- `@wpfooter` — calls `wp_footer()`
- `@wpbodyopen` — calls `wp_body_open()`

### Helper Functions (`inc/helpers.php`)
- `get_language_attributes()` — returns `language_attributes()` as string
- `get_body_class_attribute()` — returns `class="..."` attribute string

### Adding New Templates
1. Create `resources/views/<name>.blade.php` using `@extends('layouts.app')`
2. Create a root PHP file (`<name>.php`) with `ViteStarterTheme\Blade::view('<name>')`

## Asset Loading Architecture

The theme has dual-mode asset loading in `inc/assets.php` that automatically switches between development and production.

Constants:
- `VITE_DIST_URI` - Theme dist directory URI
- `VITE_MANIFEST_PATH` - Absolute path to manifest file
- `VITE_DEV_SERVER` - Dev server URL

Key functions:
- `vite_is_dev()` - Returns true when manifest doesn't exist (dev mode)
- `vite_dev_url($path)` - Builds a full dev server URL for a given asset path
- `vite_get_manifest()` - Reads and caches the production manifest
- `vite_enqueue_dev_assets()` - Enqueues Vite client + source entry points
- `vite_enqueue_production_assets()` - Enqueues hashed files from manifest

Run `npm run dev` to work with HMR (removes manifest automatically).
Run `npm run build` to switch to production mode.

## Vite Configuration

Entry points (vite.config.mjs:27-30):
- `resources/scripts/scripts.ts` - Main TypeScript entry
- `resources/styles/styles.css` - Main CSS entry (imports Tailwind and fonts)

Asset organization in production build:
- Images → `dist/images/[hash][extname]`
- Fonts → `dist/fonts/[hash][extname]`
- CSS → `dist/[hash].css`
- JS → `dist/[hash].js`

The `base` path is dynamically set based on NODE_ENV to handle WordPress subdirectory structure.

## Adding Fonts and Images

Fonts and images are imported through CSS, not PHP. Vite parses CSS files to bundle referenced assets.

**Fonts:**
1. Install fontsource package: `npm install --save @fontsource/<font-family>`
2. Import in `resources/styles/fonts.css`: `@import "@fontsource/<font-family>";`

**Images:**
- Place images in `resources/images/` and reference in CSS: `url('../images/filename.webp')`
- Only referenced images are included in the production build
- Unreferenced files in `resources/images/` will NOT appear in `dist/`
- Images are optimized via vite-plugin-image-optimizer

**Important:** Vite only bundles assets that are imported in CSS or JS. Assets referenced only in PHP won't be bundled.

## Theme Structure

### Root Level
- `functions.php` - Loads autoloader and inc/ modules
- `index.php` - Delegates to Blade view
- `header.php`, `footer.php` - Empty stubs (layout handled by Blade)

### bin/ Directory (Scripts)
- `bin/setup.js` - Interactive theme setup script
- `bin/bundle.js` - Production zip bundler (lint + build + zip)

### inc/ Directory (Theme Logic)
- `inc/Blade.php` - Blade service singleton with WordPress directives
- `inc/helpers.php` - WordPress helper functions for Blade templates
- `inc/assets.php` - Unified asset loading for dev and production modes
- `inc/cleanup.php` - WordPress cleanup (removes unnecessary scripts/styles)

### resources/views/ Directory (Blade Templates)
- `resources/views/layouts/app.blade.php` - Base HTML layout
- `resources/views/index.blade.php` - Welcome page view
- `resources/views/partials/welcome/` - Welcome page section partials

### resources/ Directory (Source Assets)
- `resources/scripts/` - TypeScript source files
- `resources/styles/` - CSS source files (Tailwind, fonts, custom styles)
- `resources/images/` - Image assets (must be referenced in CSS/JS to be bundled)
- `resources/fonts/` - Font files (if not using fontsource packages)

### dist/ Directory (Build Output)
- `dist/` - Build output directory (gitignored, created by Vite)

### storage/ Directory (Cache)
- `storage/views/` - Blade compiled template cache (gitignored)
