<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $banners = [
            'banner_home'       => 'images/banners/home-hero.jpg',
            'banner_products'   => 'images/banners/san-pham-hero.jpg',
            'banner_categories' => 'images/banners/danh-muc-hero.jpg',
            'banner_blog'       => 'images/banners/blog-hero.jpg',
            'banner_about'      => 'images/banners/about-hero.jpg',
            'banner_contact'    => 'images/banners/contact-hero.jpg',
            'banner_cart'       => 'images/banners/cart-hero.jpg',
            'banner_checkout'   => 'images/banners/checkout-hero.jpg',
        ];

        foreach ($banners as $key => $value) {
            $exists = DB::table('settings')->where('key', $key)->exists();
            if ($exists) {
                DB::table('settings')->where('key', $key)->update([
                    'value' => $value,
                    'type' => 'image',
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('settings')->insert([
                    'key' => $key,
                    'value' => $value,
                    'type' => 'image',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        $banners = [
            'banner_home', 'banner_products', 'banner_categories',
            'banner_blog', 'banner_about', 'banner_contact',
            'banner_cart', 'banner_checkout',
        ];

        DB::table('settings')->whereIn('key', $banners)->delete();
    }
};
