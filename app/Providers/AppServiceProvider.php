<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Page;
use App\Models\Setting;
use App\Services\BannerService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(BannerService::class, function () {
            return new BannerService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share site settings to every view
        View::composer('*', function ($view) {
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
        });

        // Share banners to every view (from BannerService)
        View::composer('*', function ($view) {
            static $banners = null;
            if ($banners === null) {
                try {
                    $banners = app(BannerService::class)->all();
                } catch (\Exception $e) {
                    $banners = [];
                }
            }
            $view->with('siteBanners', $banners);
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

        // Share pages for navbar
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
