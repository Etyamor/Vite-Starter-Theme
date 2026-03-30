<?php

declare(strict_types=1);

namespace ViteStarterTheme\Directives;

use Illuminate\View\Compilers\BladeCompiler;

abstract class Directive
{
    abstract public static function register(BladeCompiler $compiler): void;
}
