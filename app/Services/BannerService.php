<?php

namespace App\Services;

use App\Models\Setting;

class BannerService
{
    /**
     * Danh sách các banner keys và default values
     */
    public const BANNER_KEYS = [
        'home'       => 'images/banners/home-hero.jpg',
        'products'   => 'images/banners/san-pham-hero.jpg',
        'categories' => 'images/banners/danh-muc-hero.jpg',
        'blog'       => 'images/banners/blog-hero.jpg',
        'about'      => 'images/banners/about-hero.jpg',
        'contact'    => 'images/banners/contact-hero.jpg',
        'cart'       => 'images/banners/cart-hero.jpg',
        'checkout'   => 'images/banners/checkout-hero.png',
    ];

    /**
     * Lấy URL của banner theo key
     */
    public function get(string $key): string
    {
        $settingKey = 'banner_' . $key;
        $value = Setting::where('key', $settingKey)->value('value');

        if ($value && file_exists(public_path($value))) {
            return asset($value);
        }

        // Fallback to default
        return asset(self::BANNER_KEYS[$key] ?? 'images/placeholder.jpg');
    }

    /**
     * Lấy tất cả banners
     */
    public function all(): array
    {
        $banners = [];
        foreach (self::BANNER_KEYS as $key => $default) {
            $banners[$key] = $this->get($key);
        }
        return $banners;
    }

    /**
     * Lấy banner key từ route name hoặc URI
     */
    public function resolveKey(string $routeName): ?string
    {
        $map = [
            'home'            => 'home',
            'products.index'  => 'products',
            'products.show'   => 'products',
            'categories.index' => 'categories',
            'categories.show' => 'categories',
            'blog.index'     => 'blog',
            'blog.show'      => 'blog',
            'about'          => 'about',
            'contact'        => 'contact',
            'cart.index'     => 'cart',
            'checkout.index' => 'checkout',
            'checkout.success' => 'checkout',
        ];

        return $map[$routeName] ?? null;
    }
}
