<?php

function viburnum_theme_enqueue_theme_assets()
{
    if (viburnum_theme_is_manifest_exists()) {
        viburnum_theme_enqueue_production_assets();
    } else {
        viburnum_theme_enqueue_development_assets();
    }
}

function viburnum_theme_is_manifest_exists()
{
    return file_exists(VITE_MANIFEST_PATH);
}

function viburnum_theme_enqueue_development_assets()
{
    wp_enqueue_script('vite-client', VITE_CLIENT_PATH, [], null, true);
    add_filter('script_loader_tag', function ($tag, $handle) {
        if ($handle === 'vite-client') {
            return str_replace('<script ', '<script type="module" ', $tag);
        }
        return $tag;
    }, 10, 2);
    wp_enqueue_script('theme-scripts', VITE_SCRIPTS_PATH, [], null, true);
    wp_enqueue_style('theme-styles', VITE_STYLES_PATH, [], null);
}

function viburnum_theme_enqueue_production_assets()
{
    $manifest = json_decode(file_get_contents(VITE_MANIFEST_PATH), true);
    $themeVersion = wp_get_theme()->get('Version');
    if (is_array($manifest)) {
        foreach ($manifest as $key => $value) {
            $file = $value['file'];
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if ($ext === 'css') {
                wp_enqueue_style($key, THEME_ASSETS_DIR . '/' . $file, [], $themeVersion);
            } elseif ($ext === 'js') {
                wp_enqueue_script($key, THEME_ASSETS_DIR . '/' . $file, [], $themeVersion, true);
            }
        }
    }
}
