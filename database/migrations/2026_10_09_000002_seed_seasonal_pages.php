<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $pages = [
        'phu-kien-cay-thong' => 'Phụ kiện & đồ trang trí cây thông',
        'mua-le-hoi' => 'Mùa lễ hội',
    ];

    public function up(): void
    {
        $content = json_encode(config('seasonal'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);

        foreach ($this->pages as $slug => $title) {
            DB::table('pages')->insertOrIgnore([
                'title' => $title,
                'slug' => $slug,
                'content' => $content,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        $content = json_encode(config('seasonal'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);

        DB::table('pages')->whereIn('slug', array_keys($this->pages))->where('content', $content)->delete();
    }
};
