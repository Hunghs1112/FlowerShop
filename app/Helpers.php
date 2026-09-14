<?php

use Illuminate\Routing\UrlGenerator;

/**
 * locale_route() — Auto-injects 'locale' for all customer-facing routes.
 *
 * Replaces route() calls in views so that:
 *   route('products.index')              → works
 *   route('products.index', $product)  → works
 *   route('products.index', ['sort_by' => 'newest']) → works
 *
 * Admin routes (admin.*) are unaffected — they have no {locale} param.
 */
if (!function_exists('locale_route')) {
    function locale_route(string $name, mixed $parameters = [], bool $absolute = true): string
    {
        // Normalize parameters to array
        $params = [];
        
        if ($parameters !== null && $parameters !== []) {
            if (is_array($parameters)) {
                // Already array, use as-is
                $params = $parameters;
            } else {
                // Scalar/object - keep as indexed array, Laravel will map it
                $params = [$parameters];
            }
        }

        // List of named routes that live under the {locale} prefix group
        $localeRoutes = [
            'home', 'products.index', 'products.show',
            'categories.index', 'categories.show',
            'blog.index', 'blog.show',
            'about', 'contact', 'contact.submit', 'policy',
            'cart.index', 'cart.add', 'cart.update', 'cart.destroy', 'cart.clear',
            'quick-order.store',
            'login', 'logout',
            'password.request', 'password.email', 'password.reset', 'password.update',
            'checkout.index', 'checkout.store', 'checkout.success',
            'profile.show', 'profile.update', 'profile.password',
        ];

        if (in_array($name, $localeRoutes, true)) {
            // Need to inject locale as first parameter
            $locale = app()->getLocale();
            
            // If params is associative array and has 'locale', use as-is
            if (is_array($params) && array_key_exists('locale', $params)) {
                // Already has locale, pass through
                return app(UrlGenerator::class)->route($name, $params, $absolute);
            }
            
            // Inject locale as first parameter
            if (is_array($params) && !empty($params)) {
                // Check if it's associative or indexed
                if (array_keys($params) === range(0, count($params) - 1)) {
                    // Indexed array - prepend locale
                    array_unshift($params, $locale);
                } else {
                    // Associative array - add locale key
                    $params = ['locale' => $locale] + $params;
                }
            } else {
                $params = ['locale' => $locale];
            }
        }

        return app(UrlGenerator::class)->route($name, $params, $absolute);
    }
}

/**
 * localized_url() — Get URL for language switcher.
 * Generates proper URL for target locale by replacing the locale segment in current path.
 *
 * Example: /vi/danh-muc/valentine → /en/danh-muc/valentine
 */
if (!function_exists('localized_url')) {
    function localized_url(string $locale, ?string $fallbackRoute = null): string
    {
        $request = request();
        $path = $request->path();
        $segments = explode('/', $path);
        $supportedLocales = ['vi', 'en'];

        // If first segment is a locale, replace it
        if (isset($segments[0]) && in_array($segments[0], $supportedLocales, true)) {
            $segments[0] = $locale;
            $newPath = '/' . implode('/', $segments);
            
            // Preserve query string
            $qs = $request->getQueryString();
            return url($newPath . ($qs ? '?' . $qs : ''));
        }

        // No locale in URL — fallback to home with new locale
        return url('/' . $locale);
    }
}
