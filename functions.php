<?php

require_once 'inc/constants.php';

if (file_exists(VITE_THEME_MANIFEST_PATH)) {
    add_action('wp_enqueue_scripts', function() {
        $manifest = json_decode(file_get_contents(VITE_THEME_MANIFEST_PATH), true);
        $themeVersion = wp_get_theme()->get('Version');
        if (is_array($manifest)) {
            foreach ($manifest as $key => $value) {
                $file = $value['file'];
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if ($ext === 'css') {
                    wp_enqueue_style($key, VITE_THEME_ASSETS_DIR . '/' . $file, [], $themeVersion);
                } elseif ($ext === 'js') {
                    wp_enqueue_script($key, VITE_THEME_ASSETS_DIR . '/' . $file, [], $themeVersion, true);
                }
            }
        }
    });
} else {
    require_once 'inc/vite.php';
}

add_action('after_setup_theme', function () {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    add_action('wp_enqueue_scripts', function () {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('classic-theme-styles');
        wp_dequeue_style('global-styles');
    });
});
