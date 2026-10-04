<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pages', 'hide_header_overlay')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->boolean('hide_header_overlay')->default(false)->after('header_image');
            });
        }

        foreach (['home', 'products', 'categories', 'blog', 'about', 'contact', 'b2c', 'mystery-box', 'cart', 'checkout'] as $key) {
            DB::table('settings')->updateOrInsert(
                ['key' => 'banner_' . $key . '_hide_overlay'],
                [
                    'value' => '0',
                    'type' => 'boolean',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pages', 'hide_header_overlay')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->dropColumn('hide_header_overlay');
            });
        }

        DB::table('settings')
            ->whereIn('key', array_map(
                fn (string $key) => 'banner_' . $key . '_hide_overlay',
                ['home', 'products', 'categories', 'blog', 'about', 'contact', 'b2c', 'mystery-box', 'cart', 'checkout']
            ))
            ->delete();
    }
};
