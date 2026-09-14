<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

/**
 * locale_route() — Auto-injects 'locale' for all customer-facing routes.
 * All views call locale_route() instead of route() for routes under {locale} prefix.
 *
 * Customer routes (need locale): home, products.*, categories.*, blog.*, cart.*,
 *   checkout.*, profile.*, about, contact, policy, quick-order, auth
 * Admin routes (no locale): admin.* — use plain route() for these.
 */
if (!function_exists('locale_route')) {
    function locale_route(string $name, mixed $parameters = [], bool $absolute = true): string
    {
        $params = is_array($parameters) ? $parameters : [];

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
            $params['locale'] = $params['locale'] ?? app()->getLocale();
        }

        return app(UrlGenerator::class)->route($name, $params, $absolute);
    }
}

/**
 * localized_url() — Get URL for language switcher button.
 * Replaces current locale prefix in URL path with target locale.
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

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share site settings to every view
        View::composer('*', function ($view) {
            // Load settings once per request and share globally
            static $settings = null;
            if ($settings === null) {
                $settings = [
                    'site_name'      => Setting::get('site_name', 'Lâm Nhiên Thảo'),
                    'site_description' => Setting::get('site_description', ''),
                    'phone'          => Setting::get('phone', ''),
                    'email'          => Setting::get('email', ''),
                    'address'        => Setting::get('address', ''),
                    'zalo_id'        => Setting::get('zalo_id', ''),
                    'zalo_qr'        => Setting::get('zalo_qr', ''),
                    'facebook_url'   => Setting::get('facebook_url', ''),
                    'instagram_url'  => Setting::get('instagram_url', ''),
                    'tiktok_url'     => Setting::get('tiktok_url', ''),
                    'youtube_url'    => Setting::get('youtube_url', ''),
                ];
            }
            $view->with('siteSettings', $settings);
            $view->with('currentLocale', app()->getLocale());
        });

        // Share active categories to every view (for navbar mega menu & footer)
        View::composer('*', function ($view) {
            static $navCategories = null;
            if ($navCategories === null) {
                try {
                    $navCategories = Category::active()
                        ->orderBy('sort_order')
                        ->withCount('products')
                        ->get();
                } catch (\Exception $e) {
                    $navCategories = collect([]);
                }
            }
            $view->with('navCategories', $navCategories);
        });

        // Share active pages to every view (for navbar & footer policy links)
        View::composer('*', function ($view) {
            static $navPages = null;
            if ($navPages === null) {
                try {
                    $navPages = Page::active()
                        ->orderBy('id')
                        ->get(['id', 'title', 'slug']);
                } catch (\Exception $e) {
                    $navPages = collect([]);
                }
            }
            $view->with('navPages', $navPages);
        });
    }
}
