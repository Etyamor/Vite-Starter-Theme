# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a WordPress theme that uses Vite for asset bundling and Tailwind CSS v4 for styling. The theme is designed for minimal complexity with optimized asset handling.

## Development Commands

- `npm run dev` - Start Vite development server with HMR (clears manifest before starting)
- `npm run build` - Build production assets with Vite

## Asset Loading Architecture

The theme has unified dual-mode asset loading in `inc/assets.php` that automatically switches between development and production:

### Production Mode
- Assets are loaded from `dist/.vite/manifest.json`
- Manifest parsed to enqueue hashed CSS/JS files via WordPress hooks
- Constants defined:
  - `VITE_THEME_ASSETS_DIR` - Points to `/dist` directory
  - `VITE_THEME_MANIFEST_PATH` - Path to manifest file

### Development Mode
- When manifest doesn't exist, loads from Vite dev server at `http://localhost:5173`
- Enqueues Vite client for HMR functionality as a module script
- Development-specific constants are conditionally defined:
  - `VITE_THEME_DEV_SERVER` - Dev server URL
  - `VITE_THEME_DEV_CLIENT_PATH` - Vite client path
  - `VITE_THEME_DEV_SCRIPTS_PATH` - Scripts entry point
  - `VITE_THEME_DEV_STYLES_PATH` - Styles entry point

### Key Implementation Detail
The `inc/assets.php` file handles both modes in a unified way:
- Checks if manifest exists to determine environment
- Defines only the constants needed for the current mode
- Enqueues appropriate assets based on detected environment
- Run `npm run dev` to work with HMR (removes manifest automatically)
- Run `npm run build` to switch to production mode

## Vite Configuration

Entry points (vite.config.mjs:27-30):
- `resources/scripts/scripts.js` - Main JavaScript entry
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
- Reference images in CSS using relative paths: `url('../images/filename.webp')`
- Vite will process and optimize them during build
- Images are optimized via vite-plugin-image-optimizer

**Important:** Vite does not parse PHP files for assets. Assets referenced only in PHP won't be bundled. If needed, create a separate folder for PHP-only assets or ensure they're imported somewhere in the CSS/JS entry points.

## Theme Structure

### Root Level
- `functions.php` - Lightweight loader (requires inc/ modules)
- `header.php`, `footer.php`, `index.php` - Template wrappers (delegate to template-parts/)

### inc/ Directory (Theme Logic)
- `inc/assets.php` - Unified asset loading for dev and production modes
- `inc/cleanup.php` - WordPress cleanup (removes unnecessary scripts/styles)

### template-parts/ Directory (Actual Templates)
- `template-parts/header.php` - Actual header template
- `template-parts/footer.php` - Actual footer template
- `template-parts/index.php` - Actual index template

### resources/ Directory (Source Assets)
- `resources/scripts/` - JavaScript source files
- `resources/styles/` - CSS source files (Tailwind, fonts, custom styles)
- `resources/images/` - Image assets for Vite processing
- `resources/fonts/` - Font files (if not using fontsource packages)

### dist/ Directory (Build Output)
- `dist/` - Build output directory (gitignored, created by Vite)
