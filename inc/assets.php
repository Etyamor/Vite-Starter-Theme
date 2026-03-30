<?php

/**
 * Vite Asset Loading.
 *
 * Automatically switches between Vite dev server (HMR) and production manifest.
 * Dev mode is active when dist/.vite/manifest.json does not exist.
 *
 * @package Vite_Starter_Theme
 */

define('VITE_DIST_URI', get_template_directory_uri() . '/dist');
define('VITE_MANIFEST_PATH', get_template_directory() . '/dist/.vite/manifest.json');
define('VITE_DEV_SERVER', 'http://localhost:5173');

/**
 * Check if the theme is running in development mode.
 *
 * @return bool True if the Vite dev server should be used.
 */
function vite_is_dev(): bool
{
    return ! file_exists(VITE_MANIFEST_PATH);
}

/**
 * Build a full URL to an asset on the Vite dev server.
 *
 * @param string $path Relative path to the asset.
 * @return string Full dev server URL.
 */
function vite_dev_url(string $path): string
{
    $theme_dir = 'wp-content/themes/' . basename(get_template_directory());
    return VITE_DEV_SERVER . '/' . $theme_dir . '/' . ltrim($path, '/');
}

/**
 * Read and cache the Vite production manifest.
 *
 * @return array|null Parsed manifest or null on failure.
 */
function vite_get_manifest(): ?array
{
    static $manifest = null;

    if (null === $manifest) {
        // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Local file read.
        $content  = file_get_contents(VITE_MANIFEST_PATH);
        $manifest = $content ? json_decode($content, true) : false;
    }

    return is_array($manifest) ? $manifest : null;
}

/**
 * Enqueue assets from the Vite dev server.
 *
 * @return void
 */
function vite_enqueue_dev_assets(): void
{
    // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- Dev server assets are not versioned.
    wp_enqueue_script('vite-client', vite_dev_url('@vite/client'), array(), null, true);
    // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- Dev server assets are not versioned.
    wp_enqueue_script('theme-scripts', vite_dev_url('resources/scripts/scripts.ts'), array(), null, true);
    // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- Dev server assets are not versioned.
    wp_enqueue_style('theme-styles', vite_dev_url('resources/styles/styles.css'), array(), null);
}

/**
 * Enqueue hashed assets from the production manifest.
 *
 * @return void
 */
function vite_enqueue_production_assets(): void
{
    $manifest = vite_get_manifest();
    if (! $manifest) {
        return;
    }

    $version = wp_get_theme()->get('Version');

    foreach ($manifest as $key => $entry) {
        $file   = $entry['file'];
        $handle = 'vite-' . sanitize_title($key);
        $ext    = pathinfo($file, PATHINFO_EXTENSION);

        if ('css' === $ext) {
            wp_enqueue_style($handle, VITE_DIST_URI . '/' . $file, array(), $version);
        } elseif ('js' === $ext) {
            wp_enqueue_script($handle, VITE_DIST_URI . '/' . $file, array(), $version, true);
        }
    }
}

add_action(
    'wp_enqueue_scripts',
    function () {
        if (vite_is_dev()) {
            vite_enqueue_dev_assets();
        } else {
            vite_enqueue_production_assets();
        }
    }
);

add_filter(
    'script_loader_tag',
    function (string $tag, string $handle): string {
        if ('vite-client' === $handle || 'theme-scripts' === $handle) {
            return str_replace('<script ', '<script type="module" ', $tag);
        }
        return $tag;
    },
    10,
    2
);
