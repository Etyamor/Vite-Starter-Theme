<?php

include 'inc/constants.php';
include 'inc/enqueue.php';

add_action('wp_enqueue_scripts', 'viburnum_theme_enqueue_theme_assets');

add_action('after_setup_theme', function () {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    add_action('wp_enqueue_scripts', function () {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('classic-theme-styles');
        wp_dequeue_style('global-styles');
    });

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
});
