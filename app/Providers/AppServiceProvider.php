<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
                    'phone'          => Setting::get('phone', ''),
                    'email'          => Setting::get('email', ''),
                    'address'        => Setting::get('address', ''),
                    'facebook_url'   => Setting::get('facebook_url', ''),
                    'instagram_url'  => Setting::get('instagram_url', ''),
                    'tiktok_url'     => Setting::get('tiktok_url', ''),
                    'youtube_url'    => Setting::get('youtube_url', ''),
                    'zalo_id'        => Setting::get('zalo_id', ''),
                ];
            }
            $view->with('siteSettings', $settings);
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
    }
}
