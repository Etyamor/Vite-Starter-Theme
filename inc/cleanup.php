<?php
/**
 * WordPress Cleanup
 *
 * Strips all default WordPress frontend output that a custom
 * Vite-powered theme does not need.
 */

add_action('after_setup_theme', function () {
    // Meta tags
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    remove_action('wp_head', 'wp_resource_hints', 2);

    // Emoji
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    // oEmbed
    remove_action('rest_api_init', 'wp_oembed_register_route');
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

    // XML-RPC
    add_filter('xmlrpc_enabled', '__return_false');

    // Feed links
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
});

// Block styles and global styles
add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('global-styles');
    wp_dequeue_style('core-block-supports');
}, 100);

// Remove global styles inline CSS
remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_footer', 'wp_enqueue_global_styles', 1);

// Remove auto-sizes contain inline CSS
remove_action('wp_head', 'wp_enqueue_img_auto_sizes_contain_css_fix', 0);
remove_action('wp_head', 'wp_print_auto_sizes_contain_css_fix', 1);

// Disable self-pingbacks
add_action('pre_ping', function (array &$links) {
    $home = home_url();
    foreach ($links as $i => $link) {
        if (str_starts_with($link, $home)) {
            unset($links[$i]);
        }
    }
});

// Remove query strings from static resources
add_filter('script_loader_src', 'vite_remove_version_query', 15);
add_filter('style_loader_src', 'vite_remove_version_query', 15);

function vite_remove_version_query(string $src): string {
    if (str_contains($src, '?ver=')) {
        return remove_query_arg('ver', $src);
    }
    return $src;
}

// Disable REST API user enumeration for non-logged-in users
add_filter('rest_endpoints', function (array $endpoints): array {
    if (! is_user_logged_in()) {
        unset($endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
    return $endpoints;
});

// Remove SVG and global styles duplication
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

// Remove dashicons on frontend for non-logged-in users
add_action('wp_enqueue_scripts', function () {
    if (! is_user_logged_in()) {
        wp_dequeue_style('dashicons');
    }
});

// Disable WordPress sitemap (use a SEO plugin instead)
add_filter('wp_sitemaps_enabled', '__return_false');

// Remove jQuery migrate
add_action('wp_default_scripts', function ($scripts) {
    if (! is_admin() && isset($scripts->registered['jquery'])) {
        $scripts->registered['jquery']->deps = array_diff(
            $scripts->registered['jquery']->deps,
            ['jquery-migrate']
        );
    }
});
