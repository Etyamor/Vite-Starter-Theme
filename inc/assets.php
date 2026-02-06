<?php
/**
 * Asset Loading - Unified Dev and Production
 */

// Define production constants (needed to check environment)
define('VITE_THEME_ASSETS_DIR', get_template_directory_uri() . '/dist');
define('VITE_THEME_MANIFEST_PATH', get_template_directory() . '/dist/.vite/manifest.json');

// Environment detection
$vite_is_production = file_exists(VITE_THEME_MANIFEST_PATH);

// Define mode-specific constants
if (!$vite_is_production) {
    // Development constants
    define('VITE_THEME_DEV_SERVER', 'http://localhost:5173');
    define('VITE_THEME_DEV_DIR', 'wp-content/themes/' . basename(get_template_directory()));
    define('VITE_THEME_DEV_ASSETS_DIR', VITE_THEME_DEV_DIR . '/resources');
    define('VITE_THEME_DEV_CLIENT_PATH', VITE_THEME_DEV_SERVER . '/' . VITE_THEME_DEV_DIR . '/@vite/client');
    define('VITE_THEME_DEV_SCRIPTS_PATH', VITE_THEME_DEV_SERVER . '/' . VITE_THEME_DEV_ASSETS_DIR . '/scripts/scripts.js');
    define('VITE_THEME_DEV_STYLES_PATH', VITE_THEME_DEV_SERVER . '/' . VITE_THEME_DEV_ASSETS_DIR . '/styles/styles.css');
}

// Unified asset enqueuing
add_action('wp_enqueue_scripts', function() use ($vite_is_production) {
    $theme_version = wp_get_theme()->get('Version');

    if ($vite_is_production) {
        // Production: Load from manifest
        $manifest = json_decode(file_get_contents(VITE_THEME_MANIFEST_PATH), true);
        if (is_array($manifest)) {
            foreach ($manifest as $key => $value) {
                $file   = $value['file'];
                $ext    = pathinfo($file, PATHINFO_EXTENSION);
                $handle = 'vite-' . sanitize_title($key);
                if ($ext === 'css') {
                    wp_enqueue_style($handle, VITE_THEME_ASSETS_DIR . '/' . $file, [], $theme_version);
                } elseif ($ext === 'js') {
                    wp_enqueue_script($handle, VITE_THEME_ASSETS_DIR . '/' . $file, [], $theme_version, true);
                }
            }
        }
    } else {
        // Development: Load from Vite dev server
        wp_enqueue_script('vite-client', VITE_THEME_DEV_CLIENT_PATH, [], null, true);

        add_filter('script_loader_tag', function ($tag, $handle) {
            if ($handle === 'vite-client') {
                return str_replace('<script ', '<script type="module" ', $tag);
            }
            return $tag;
        }, 10, 2);

        wp_enqueue_script('theme-scripts', VITE_THEME_DEV_SCRIPTS_PATH, [], null, true);
        wp_enqueue_style('theme-styles', VITE_THEME_DEV_STYLES_PATH, [], null);
    }
});
