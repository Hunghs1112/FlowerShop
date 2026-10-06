<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ThemeContractTest extends TestCase
{
    public function test_shared_theme_exposes_both_palettes_and_toggle(): void
    {
        $css = file_get_contents(__DIR__.'/../../public/css/theme.css');
        $bundle = file_get_contents(__DIR__.'/../../public/css/app.css');
        $head = file_get_contents(__DIR__.'/../../resources/views/partials/theme-head.blade.php');
        $navbar = file_get_contents(__DIR__.'/../../resources/views/partials/navbar.blade.php');

        $this->assertStringContainsString('--color-cream: #F5EBE6', $css);
        $this->assertStringContainsString(':root[data-theme="dark"]', $css);
        $this->assertStringContainsString('--color-cream: #211915', $css);
        $this->assertStringContainsString('--font-sans: "Josefin Sans"', $bundle);
        $this->assertStringContainsString(':root[data-theme="dark"]', $bundle);
        $this->assertStringContainsString("localStorage.setItem(key, theme)", $head);
        $this->assertStringContainsString('data-theme-toggle', $navbar);
    }
}
