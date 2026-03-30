<?php

declare(strict_types=1);

namespace ViteStarterTheme;

use Illuminate\Container\Container;
use Jenssegers\Blade\Blade as BladeEngine;
use ViteStarterTheme\Directives\HtmlDirectives;
use ViteStarterTheme\Directives\WordPressDirectives;

class Blade
{
    private static ?BladeEngine $instance = null;

    /** @var array<class-string<Directives\Directive>> */
    private static array $directives = [
        WordPressDirectives::class,
        HtmlDirectives::class,
    ];

    public static function getInstance(): BladeEngine
    {
        if (self::$instance === null) {
            $viewsPath = get_template_directory() . '/resources/views';
            $cachePath = get_template_directory() . '/storage/views';

            if (!is_dir($cachePath)) {
                wp_mkdir_p($cachePath);
            }

            $container = new \Jenssegers\Blade\Container();
            Container::setInstance($container);

            self::$instance = new BladeEngine($viewsPath, $cachePath, $container);

            $compiler = self::$instance->compiler();
            foreach (self::$directives as $directive) {
                $directive::register($compiler);
            }
        }

        return self::$instance;
    }

    public static function render(string $view, array $data = []): string
    {
        return self::getInstance()->make($view, $data)->render();
    }

    public static function view(string $view, array $data = []): void
    {
        echo self::render($view, $data); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
