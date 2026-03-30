<?php

/**
 * Blade directive IDE helper.
 *
 * This file is not loaded at runtime. It exists solely to provide
 * autocompletion and navigation for custom Blade directives in IDEs.
 *
 * @see \ViteStarterTheme\Directives\WordPressDirectives
 * @see \ViteStarterTheme\Directives\HtmlDirectives
 */

namespace ViteStarterTheme\BladeDirectives;

/**
 * Output wp_head() — enqueues styles, scripts, and meta tags.
 *
 * Usage: @wphead
 */
function wphead(): void
{
    wp_head();
}

/**
 * Output wp_footer() — enqueues footer scripts and fires wp_footer hook.
 *
 * Usage: @wpfooter
 */
function wpfooter(): void
{
    wp_footer();
}

/**
 * Output wp_body_open() — fires the wp_body_open action after <body> tag.
 *
 * Usage: @wpbodyopen
 */
function wpbodyopen(): void
{
    wp_body_open();
}

/**
 * Output HTML language attributes for the <html> tag.
 *
 * Usage: @langattributes
 */
function langattributes(): void
{
    echo \ViteStarterTheme\Helpers::languageAttributes();
}

/**
 * Output body class attribute.
 *
 * Usage: @bodyclass or @bodyclass('extra-class')
 *
 * @param string|string[] $classes Additional CSS classes.
 */
function bodyclass(string|array $classes = ''): void
{
    echo \ViteStarterTheme\Helpers::bodyClassAttribute($classes);
}
