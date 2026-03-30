<?php

declare(strict_types=1);

namespace ViteStarterTheme;

class Cleanup
{
    public static function register(): void
    {
        add_action('after_setup_theme', [self::class, 'removeHeadJunk']);
        add_action('wp_enqueue_scripts', [self::class, 'dequeueBlockStyles'], 100);
        add_action('pre_ping', [self::class, 'disableSelfPingbacks']);
        add_action('wp_enqueue_scripts', [self::class, 'removeDashicons']);
        add_action('wp_default_scripts', [self::class, 'removeJqueryMigrate']);

        remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
        remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
        remove_action('wp_head', 'wp_enqueue_img_auto_sizes_contain_css_fix', 0);
        remove_action('wp_head', 'wp_print_auto_sizes_contain_css_fix', 1);
        remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

        add_filter('xmlrpc_enabled', '__return_false');
        add_filter('wp_sitemaps_enabled', '__return_false');
        add_filter('script_loader_src', [self::class, 'removeVersionQuery'], 15);
        add_filter('style_loader_src', [self::class, 'removeVersionQuery'], 15);
        add_filter('rest_endpoints', [self::class, 'disableUserEnumeration']);
    }

    public static function removeHeadJunk(): void
    {
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wp_shortlink_wp_head');
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
        remove_action('wp_head', 'rest_output_link_wp_head', 10);
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
        remove_action('wp_head', 'wp_resource_hints', 2);
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'feed_links_extra', 3);

        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

        remove_action('rest_api_init', 'wp_oembed_register_route');
        remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    }

    public static function dequeueBlockStyles(): void
    {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('classic-theme-styles');
        wp_dequeue_style('global-styles');
        wp_dequeue_style('core-block-supports');
    }

    public static function disableSelfPingbacks(array &$links): void
    {
        $home = home_url();
        foreach ($links as $i => $link) {
            if (str_starts_with($link, $home)) {
                unset($links[$i]);
            }
        }
    }

    public static function removeVersionQuery(string $src): string
    {
        if (str_contains($src, '?ver=')) {
            return remove_query_arg('ver', $src);
        }
        return $src;
    }

    public static function disableUserEnumeration(array $endpoints): array
    {
        if (!is_user_logged_in()) {
            unset($endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)']);
        }
        return $endpoints;
    }

    public static function removeDashicons(): void
    {
        if (!is_user_logged_in()) {
            wp_dequeue_style('dashicons');
        }
    }

    public static function removeJqueryMigrate(\WP_Scripts $scripts): void
    {
        if (!is_admin() && isset($scripts->registered['jquery'])) {
            $scripts->registered['jquery']->deps = array_diff(
                $scripts->registered['jquery']->deps,
                ['jquery-migrate']
            );
        }
    }
}
