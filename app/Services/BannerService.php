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

    public const DEFAULT_HEIGHTS = [
        'home'        => ['desktop' => 720, 'mobile' => 420],
        'products'    => ['desktop' => 400, 'mobile' => 280],
        'categories'  => ['desktop' => 400, 'mobile' => 280],
        'blog'        => ['desktop' => 420, 'mobile' => 300],
        'about'       => ['desktop' => 400, 'mobile' => 300],
        'contact'     => ['desktop' => 400, 'mobile' => 300],
        'b2c'         => ['desktop' => 420, 'mobile' => 320],
        'mystery-box' => ['desktop' => 400, 'mobile' => 300],
        'cart'        => ['desktop' => 350, 'mobile' => 260],
        'checkout'    => ['desktop' => 350, 'mobile' => 260],
    ];

    /**
     * Lấy chiều cao hiển thị (từ settings, fallback về DEFAULT_HEIGHTS).
     */
    public function sizes(): array
    {
        $sizes = [];
        foreach (self::DEFAULT_HEIGHTS as $key => $defaults) {
            $sizes[$key] = [
                'desktop' => (int) Setting::get('banner_' . $key . '_height_desktop', $defaults['desktop']),
                'mobile'  => (int) Setting::get('banner_' . $key . '_height_mobile',  $defaults['mobile']),
            ];
        }
        return $sizes;
    }

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
