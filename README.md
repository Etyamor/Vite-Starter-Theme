# Viburnum Theme

Viburnum Theme is a modern WordPress theme that leverages Vite for asset bundling and optimization, designed to provide
a fast and efficient development experience.

## Features

- **Vite Integration**: Utilizes Vite for fast development and optimized production builds.
- **Zero Complexity**: Just develop. Vite handles everything.
- **Optimized Assets**: Automatically minifies and optimizes assets for production.
- **Tailwind CSS**: Includes Tailwind CSS for rapid development. It is time to use it in WordPress.

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

To start the development server with Vite:

```sh
npm run dev
```

To install new fonts, you can use the following command:

```sh
npm install --save fontsource-<font-family>
```

Then, you can import the font in the `resources/styles/fonts.css` file:

```css
@import 'fontsource-<font-family>';
```

## Notes

Vite does not parse PHP files for used assets. If you want to use assets in PHP files, you need to add another folder
for these kinds of assets.

Attribution to the original author is appreciated but not required. Feel free to use this theme without including my
name.

