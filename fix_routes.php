<?php
/**
 * Replace route() with locale_route() in Blade view files.
 * locale_route() auto-injects {locale} parameter for customer routes.
 *
 * Usage: php fix_routes.php
 */

$basePath = __DIR__;

// All customer-facing views (need locale_route)
$files = [
    'resources/views/partials/navbar.blade.php',
    'resources/views/partials/footer.blade.php',
    'resources/views/partials/product-card.blade.php',
    'resources/views/home/sections/hero.blade.php',
    'resources/views/home/sections/products.blade.php',
    'resources/views/home/sections/categories.blade.php',
    'resources/views/home/sections/inspiration.blade.php',
    'resources/views/home/index.blade.php',
    'resources/views/home/index-backup.blade.php',
    'resources/views/products/index.blade.php',
    'resources/views/products/detail.blade.php',
    'resources/views/categories/index.blade.php',
    'resources/views/categories/show.blade.php',
    'resources/views/cart/index.blade.php',
    'resources/views/checkout/index.blade.php',
    'resources/views/checkout/success.blade.php',
    'resources/views/blog/index.blade.php',
    'resources/views/blog/show.blade.php',
    'resources/views/pages/contact.blade.php',
    'resources/views/pages/about.blade.php',
    'resources/views/pages/policy.blade.php',
    'resources/views/auth/login.blade.php',
    'resources/views/auth/passwords/email.blade.php',
    'resources/views/auth/passwords/reset.blade.php',
    'resources/views/profile/show.blade.php',
];

$changed = 0;

foreach ($files as $file) {
    $path = $basePath . '/' . $file;
    if (!file_exists($path)) {
        echo "SKIP (not found): $file\n";
        continue;
    }

    $content = file_get_contents($path);
    $original = $content;

    // Replace inside {{ }} Blade expressions: {{ route(...) → {{ locale_route(...)
    $content = preg_replace('/\{\{\s*route\(/', '{{ locale_route(', $content);

    // Replace inside @ Blade directives: @section(route( ... → @section(locale_route(...
    // Only match @ followed by a word (blade directive), then (, then route(
    $content = preg_replace('/@(?!php\b)([a-zA-Z]+)\s*\(route\(/', '@$1(locale_route(', $content);

    if ($content !== $original) {
        file_put_contents($path, $content);
        echo "FIXED: $file\n";
        $changed++;
    } else {
        echo "OK (no change): $file\n";
    }
}

echo "\nFixed $changed files.\n";
