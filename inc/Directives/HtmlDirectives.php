<?php

declare(strict_types=1);

namespace ViteStarterTheme\Directives;

use Illuminate\View\Compilers\BladeCompiler;
use ViteStarterTheme\Helpers;

class HtmlDirectives extends Directive
{
    public static function register(BladeCompiler $compiler): void
    {
        $compiler->directive('langattributes', function () {
            return '<?php echo ' . Helpers::class . '::languageAttributes(); ?>';
        });

        $compiler->directive('bodyclass', function ($expression) {
            $expression = $expression ?: "''";
            return '<?php echo ' . Helpers::class . "::bodyClassAttribute($expression); ?>";
        });
    }
}
