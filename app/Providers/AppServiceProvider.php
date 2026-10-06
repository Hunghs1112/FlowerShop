<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Page;
use App\Services\BannerService;
use App\Services\SettingService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(BannerService::class, fn () => new BannerService());
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('siteSettings', app(SettingService::class)->getSiteInfo());
        });

        View::composer('*', function ($view) {
            try { $banners = app(BannerService::class)->all(); } catch (\Throwable) { $banners = []; }
            $view->with('siteBanners', $banners);
        });

        View::composer('*', function ($view) {
            $hideOverlay = [];
            foreach (array_keys(BannerService::BANNER_KEYS) as $key) {
                $hideOverlay[$key] = (bool) app(SettingService::class)->get('banner_' . $key . '_hide_overlay', false);
            }
            $view->with('siteBannerHideOverlay', $hideOverlay);
        });

        View::composer('*', function ($view) {
            $view->with('siteBannerSizes', app(BannerService::class)->sizes());
        });

        View::composer('*', function ($view) {
            try {
                $categories = Category::active()->orderBy('sort_order')->withCount('products')->get();
            } catch (\Throwable) { $categories = collect(); }
            $view->with('navCategories', $categories);
        });

        View::composer('*', function ($view) {
            try { $pages = Page::active()->orderBy('id')->get(['id', 'title', 'slug']); }
            catch (\Throwable) { $pages = collect(); }
            $view->with('navPages', $pages);
        });
    }
}
