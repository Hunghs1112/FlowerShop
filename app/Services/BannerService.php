<?php

namespace App\Services;

use App\Models\Setting;

/**
 * BannerService — Quản lý ảnh header cho từng trang.
 *
 * Ảnh header được lưu trong bảng settings với key: banner_{page}
 * Ví dụ: banner_home, banner_categories, banner_blog, ...
 *
 * Không còn dùng table `banners` (banner slider đã bị xóa).
 */
class BannerService
{
    /**
     * Keys và default file cho mỗi trang.
     */
    public const BANNER_KEYS = [
        'home'        => 'images/banners/home-hero.jpg',
        'products'    => 'images/banners/san-pham-hero.jpg',
        'categories'  => 'images/banners/danh-muc-hero.jpg',
        'blog'        => 'images/banners/blog-hero.jpg',
        'about'       => 'images/banners/about-hero.jpg',
        'contact'     => 'images/banners/contact-hero.jpg',
        'b2c'         => 'images/banners/b2c-hero.jpg',
        'mystery-box' => 'images/banners/mystery-box-hero.jpg',
        'cart'        => 'images/banners/cart-hero.jpg',
        'checkout'    => 'images/banners/checkout-hero.png',
    ];

    /**
     * Lấy URL ảnh header cho 1 trang.
     * Đọc từ settings table, fallback về file tĩnh mặc định.
     */
    public function get(string $key): string
    {
        $settingKey = 'banner_' . $key;
        $value      = Setting::where('key', $settingKey)->value('value');

        if ($value && file_exists(public_path($value))) {
            return asset($value);
        }

        return asset(self::BANNER_KEYS[$key] ?? 'images/placeholder.jpg');
    }

    /**
     * Lấy tất cả banner URL (dùng trong Settings / PageBanners view).
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
     * Resolve banner key từ route name (dùng trong AppServiceProvider).
     */
    public function resolveKey(string $routeName): ?string
    {
        $map = [
            'home'             => 'home',
            'products.index'   => 'products',
            'products.show'    => 'products',
            'categories.index' => 'categories',
            'categories.show'  => 'categories',
            'blog.index'       => 'blog',
            'blog.show'        => 'blog',
            'about'            => 'about',
            'contact'          => 'contact',
            'b2c'              => 'b2c',
            'cart.index'       => 'cart',
            'checkout.index'   => 'checkout',
            'checkout.success' => 'checkout',
        ];

        return $map[$routeName] ?? null;
    }
}
