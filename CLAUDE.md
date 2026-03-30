# CLAUDE.md

This file provides guidance for AI coding assistants when working with code in this repository.

## Project Overview

This is a WordPress theme that uses Vite for asset bundling and Tailwind CSS v4 for styling. The theme is designed for minimal complexity with optimized asset handling.

## Development Commands

- `npm run dev` - Start Vite development server with HMR (clears manifest before starting)
- `npm run build` - Build production assets with Vite
- `npm run lint` - Run PHPCS, PHPStan, and Stylelint together
- `npm run lint:php` - Check PHP against WordPress coding standards
- `npm run lint:php:fix` - Auto-fix PHPCS violations
- `npm run lint:types` - Run PHPStan static analysis (level 5)
- `npm run lint:css` - Check CSS with Stylelint
- `npm run lint:css:fix` - Auto-fix Stylelint violations
- `npm run typecheck` - Run TypeScript type checking
- `npm run bundle` - Lint + build + create production zip
- `npm run bundle:quick` - Build + zip (skip linting)
- `npm run bundle:clean` - Remove the bundled/ directory

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
- `functions.php` - Lightweight loader (requires inc/ modules)
- `header.php`, `footer.php`, `index.php` - Template wrappers (delegate to template-parts/)

### bin/ Directory (Scripts)
- `bin/setup.js` - Interactive theme setup script
- `bin/bundle.js` - Production zip bundler (lint + build + zip)

### inc/ Directory (Theme Logic)
- `inc/assets.php` - Unified asset loading for dev and production modes
- `inc/cleanup.php` - WordPress cleanup (removes unnecessary scripts/styles)

### template-parts/ Directory (Actual Templates)
- `template-parts/header.php` - Actual header template
- `template-parts/footer.php` - Actual footer template
- `template-parts/index.php` - Actual index template

### resources/ Directory (Source Assets)
- `resources/scripts/` - TypeScript source files
- `resources/styles/` - CSS source files (Tailwind, fonts, custom styles)
- `resources/images/` - Image assets (must be referenced in CSS/JS to be bundled)
- `resources/fonts/` - Font files (if not using fontsource packages)

### dist/ Directory (Build Output)
- `dist/` - Build output directory (gitignored, created by Vite)
