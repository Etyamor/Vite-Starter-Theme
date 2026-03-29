<?php
/**
 * Vite Asset Loading
 *
 * Automatically switches between Vite dev server (HMR) and production manifest.
 * Dev mode is active when dist/.vite/manifest.json does not exist.
 */

define('VITE_DIST_URI', get_template_directory_uri() . '/dist');
define('VITE_MANIFEST_PATH', get_template_directory() . '/dist/.vite/manifest.json');
define('VITE_DEV_SERVER', 'http://localhost:5173');

function vite_is_dev(): bool {
    return ! file_exists(VITE_MANIFEST_PATH);
}

function vite_dev_url(string $path): string {
    $theme_dir = 'wp-content/themes/' . basename(get_template_directory());
    return VITE_DEV_SERVER . '/' . $theme_dir . '/' . ltrim($path, '/');
}

function vite_get_manifest(): ?array {
    static $manifest = null;

    if ($manifest === null) {
        $content  = file_get_contents(VITE_MANIFEST_PATH);
        $manifest = $content ? json_decode($content, true) : false;
    }

    return is_array($manifest) ? $manifest : null;
}

function vite_enqueue_dev_assets(): void {
    wp_enqueue_script('vite-client', vite_dev_url('@vite/client'), [], null, true);
    wp_enqueue_script('theme-scripts', vite_dev_url('resources/scripts/scripts.ts'), [], null, true);
    wp_enqueue_style('theme-styles', vite_dev_url('resources/styles/styles.css'), [], null);
}

function vite_enqueue_production_assets(): void {
    $manifest = vite_get_manifest();
    if (! $manifest) {
        return;
    }

    $version = wp_get_theme()->get('Version');

    foreach ($manifest as $key => $entry) {
        $file   = $entry['file'];
        $handle = 'vite-' . sanitize_title($key);
        $ext    = pathinfo($file, PATHINFO_EXTENSION);

        if ($ext === 'css') {
            wp_enqueue_style($handle, VITE_DIST_URI . '/' . $file, [], $version);
        } elseif ($ext === 'js') {
            wp_enqueue_script($handle, VITE_DIST_URI . '/' . $file, [], $version, true);
        }
    }
}

add_action('wp_enqueue_scripts', function () {
    if (vite_is_dev()) {
        vite_enqueue_dev_assets();
    } else {
        vite_enqueue_production_assets();
    }
});

add_filter('script_loader_tag', function (string $tag, string $handle): string {
    if ($handle === 'vite-client' || $handle === 'theme-scripts') {
        return str_replace('<script ', '<script type="module" ', $tag);
    }
    return $tag;
}, 10, 2);
