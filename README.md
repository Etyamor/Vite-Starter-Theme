# Vite Starter Theme

A modern WordPress theme that leverages Vite for asset bundling and Tailwind CSS v4 for styling. Built with a clean, modular architecture for optimal development experience.

## Features

- **⚡ Vite Integration** - Lightning-fast HMR and optimized builds
- **🎨 Tailwind CSS v4** - Latest Tailwind with native CSS layer support
- **📦 Modular Architecture** - Organized file structure with clear separation of concerns
- **🚀 Dual-Mode Asset Loading** - Automatic switching between dev and production
- **🧹 WordPress Cleanup** - Removes unnecessary WordPress bloat
- **🖼️ Optimized Assets** - Automatic image optimization and asset hashing

## Installation

1. Clone the repository into your WordPress `wp-content/themes` directory.
2. Navigate to the theme directory and install dependencies:
    ```sh
    npm install
    ```
3. Build the assets:
    ```sh
    npm run build
    ```
4. Activate the theme from the WordPress admin panel.

## Development

Start the development server with hot module replacement:

```sh
npm run dev
```

This will:
- Start Vite dev server on `http://localhost:5173`
- Enable hot module replacement (HMR)
- Remove the manifest file to activate dev mode

Build for production:

```sh
npm run build
```

This creates optimized assets in the `dist/` directory with hashed filenames.

## Project Structure

```
theme-root/
├── functions.php              # Lightweight loader
├── header.php                 # Template wrapper
├── footer.php                 # Template wrapper
├── index.php                  # Template wrapper
├── inc/
│   ├── assets.php            # Unified asset loading (dev + production)
│   └── cleanup.php           # WordPress cleanup hooks
├── template-parts/
│   ├── header.php            # Actual header template
│   ├── footer.php            # Actual footer template
│   └── index.php             # Actual index template
└── resources/
    ├── scripts/              # JavaScript source files
    ├── styles/               # CSS source files
    ├── images/               # Image assets
    └── fonts/                # Font files (optional)
```

## Adding Fonts

Install a fontsource package:

```sh
npm install --save @fontsource/<font-family>
```

Import in `resources/styles/fonts.css`:

```css
@import '@fontsource/<font-family>';
```

## Adding Images

Reference images in CSS using relative paths:

```css
.hero {
    background-image: url('../images/hero.webp');
}
```

Vite will automatically process and optimize them during build.

## Important Notes

- **Vite does not parse PHP files** for assets. Assets must be imported in CSS/JS entry points to be bundled.
- The theme automatically detects dev vs production mode based on manifest file existence.
- All templates are in `template-parts/` for better organization.

## License

Feel free to use this theme however you like. Attribution appreciated but not required.

