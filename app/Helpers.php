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
        // Normalize: if $parameters is scalar (e.g. a model), wrap in array
        if (!is_array($parameters) && $parameters !== null) {
            $parameters = [$parameters];
        }
        $params = is_array($parameters) ? $parameters : [];

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
            // Inject locale only if not already present in params
            if (!array_key_exists('locale', $params)) {
                $params['locale'] = app()->getLocale();
            }
        }

        return app(UrlGenerator::class)->route($name, $params, $absolute);
    }
}

/**
 * localized_url() — Get URL for language switcher.
 * Replaces the current locale prefix in the URL path with a new locale.
 *
 * Example: /vi/san-pham → /en/san-pham
 */
if (!function_exists('localized_url')) {
    function localized_url(string $locale, ?string $fallbackRoute = null): string
    {
        $request = request();
        $path = $request->path();
        $segments = explode('/', $path);
        $supportedLocales = ['vi', 'en'];

        // Replace locale prefix if present
        if (in_array($segments[0] ?? '', $supportedLocales, true)) {
            $segments[0] = $locale;
            $qs = $request->getQueryString();
            return '/' . implode('/', $segments) . ($qs ? '?' . $qs : '');
        }

        // No locale in URL — build from fallback route
        if ($fallbackRoute) {
            return app(UrlGenerator::class)->route($fallbackRoute, ['locale' => $locale], false);
        }

        return '/' . $locale;
    }
}
