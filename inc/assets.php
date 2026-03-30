<?php

declare(strict_types=1);

namespace ViteStarterTheme;

class Assets
{
    private const DIST_DIR = '/dist';
    private const MANIFEST_FILE = '/dist/.vite/manifest.json';
    private const DEV_SERVER = 'http://localhost:5173';

    private static ?array $manifest = null;

    public static function register(): void
    {
        add_action('wp_enqueue_scripts', [self::class, 'enqueue']);
        add_filter('script_loader_tag', [self::class, 'moduleScriptTag'], 10, 2);
    }

    public static function enqueue(): void
    {
        if (self::isDev()) {
            self::enqueueDev();
        } else {
            self::enqueueProduction();
        }
    }

    public static function moduleScriptTag(string $tag, string $handle): string
    {
        if ($handle === 'vite-client' || $handle === 'theme-scripts') {
            return str_replace('<script ', '<script type="module" ', $tag);
        }
        return $tag;
    }

    public static function isDev(): bool
    {
        return !file_exists(get_template_directory() . self::MANIFEST_FILE);
    }

    public static function distUri(): string
    {
        return get_template_directory_uri() . self::DIST_DIR;
    }

    private static function devUrl(string $path): string
    {
        $themeDir = 'wp-content/themes/' . basename(get_template_directory());
        return self::DEV_SERVER . '/' . $themeDir . '/' . ltrim($path, '/');
    }

    private static function getManifest(): ?array
    {
        if (self::$manifest === null) {
            $content = file_get_contents(get_template_directory() . self::MANIFEST_FILE);
            self::$manifest = $content ? json_decode($content, true) : false;
        }

        return is_array(self::$manifest) ? self::$manifest : null;
    }

    private static function enqueueDev(): void
    {
        wp_enqueue_script('vite-client', self::devUrl('@vite/client'), [], null, true);
        wp_enqueue_script('theme-scripts', self::devUrl('resources/scripts/scripts.ts'), [], null, true);
        wp_enqueue_style('theme-styles', self::devUrl('resources/styles/styles.css'), [], null);
    }

    private static function enqueueProduction(): void
    {
        $manifest = self::getManifest();
        if (!$manifest) {
            return;
        }

        $version = wp_get_theme()->get('Version');

        foreach ($manifest as $key => $entry) {
            $file = $entry['file'];
            $handle = 'vite-' . sanitize_title($key);
            $ext = pathinfo($file, PATHINFO_EXTENSION);

            if ($ext === 'css') {
                wp_enqueue_style($handle, self::distUri() . '/' . $file, [], $version);
            } elseif ($ext === 'js') {
                wp_enqueue_script($handle, self::distUri() . '/' . $file, [], $version, true);
            }
        }
    }
}
