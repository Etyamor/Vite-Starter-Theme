<?php

declare(strict_types=1);

namespace ViteStarterTheme\Directives;

use Illuminate\View\Compilers\BladeCompiler;

class WordPressDirectives extends Directive
{
    public static function register(BladeCompiler $compiler): void
    {
        $compiler->directive('wphead', function () {
            return '<?php wp_head(); ?>';
        });

        $compiler->directive('wpfooter', function () {
            return '<?php wp_footer(); ?>';
        });

        $compiler->directive('wpbodyopen', function () {
            return '<?php wp_body_open(); ?>';
        });
    }
}
