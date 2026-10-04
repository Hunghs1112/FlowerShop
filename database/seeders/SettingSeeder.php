<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Site Info
            ['key' => 'site_name', 'value' => 'Lâm Nhiên Thảo', 'type' => 'text'],
            ['key' => 'site_description', 'value' => 'Hoa tươi cao cấp và hoa nhập khẩu cho mọi dịp đặc biệt', 'type' => 'text'],
            ['key' => 'phone', 'value' => '0909999999', 'type' => 'text'],
            ['key' => 'email', 'value' => 'contact@lamnhienthao.vn', 'type' => 'text'],
            ['key' => 'address', 'value' => '123 Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh', 'type' => 'text'],
            ['key' => 'zalo_id', 'value' => '0909999999', 'type' => 'text'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/lamnhienthao', 'type' => 'text'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/lamnhienthao', 'type' => 'text'],
            ['key' => 'about', 'value' => 'Chúng tôi đam mê mang đến vẻ đẹp của hoa tươi và hoa nhập khẩu cho mọi dịp đặc biệt. Đội ngũ florist chuyên nghiệp của chúng tôi cẩn thận lựa chọn và thiết kế từng bó hoa để đảm bảo chất lượng và sự tinh tế.', 'type' => 'textarea'],
            
            // Banners (for page-hero sections)
            ['key' => 'banner_home', 'value' => 'images/banners/home-hero.jpg', 'type' => 'image'],
            ['key' => 'banner_products', 'value' => 'images/banners/san-pham-hero.jpg', 'type' => 'image'],
            ['key' => 'banner_categories', 'value' => 'images/banners/danh-muc-hero.jpg', 'type' => 'image'],
            ['key' => 'banner_blog', 'value' => 'images/banners/blog-hero.jpg', 'type' => 'image'],
            ['key' => 'banner_about', 'value' => 'images/banners/about-hero.jpg', 'type' => 'image'],
            ['key' => 'banner_contact', 'value' => 'images/banners/contact-hero.jpg', 'type' => 'image'],
            ['key' => 'banner_b2c', 'value' => 'images/banners/b2c-hero.jpg', 'type' => 'image'],
            ['key' => 'banner_mystery-box', 'value' => 'images/banners/mystery-box-hero.jpg', 'type' => 'image'],
            ['key' => 'banner_cart', 'value' => 'images/banners/cart-hero.jpg', 'type' => 'image'],
            ['key' => 'banner_checkout', 'value' => 'images/banners/checkout-hero.png', 'type' => 'image'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                ]
            );
        }
    }
}
