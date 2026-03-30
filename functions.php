<?php

/**
 * Theme Setup - Main entry point.
 *
 * @package Vite_Starter_Theme
 */

declare(strict_types=1);

require_once get_template_directory() . '/vendor/autoload.php';

ViteStarterTheme\Assets::register();
ViteStarterTheme\Cleanup::register();
