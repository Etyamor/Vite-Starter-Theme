<?php

declare(strict_types=1);

namespace ViteStarterTheme;

class Helpers
{
    public static function languageAttributes(): string
    {
        ob_start();
        language_attributes();
        return (string) ob_get_clean();
    }

    /**
     * @param string|string[] $classes Additional classes.
     */
    public static function bodyClassAttribute(string|array $classes = ''): string
    {
        return 'class="' . esc_attr(implode(' ', get_body_class($classes))) . '"';
    }
}
