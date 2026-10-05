<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('flower_origins')->insert([
            'slug' => 'colombia',
            'map_x' => 235,
            'map_y' => 282,
            'country' => 'Colombia',
            'flower' => 'Cẩm chướng',
            'latin' => 'Dianthus caryophyllus',
            'region' => 'Bogotá',
            'coordinate' => '4.71°N, 74.07°W',
            'image' => 'images/products/hoa-cam-chuong.jpg',
            'sort_order' => 8,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('flower_origins')
            ->where('slug', 'new-zealand')
            ->update(['sort_order' => 9, 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('flower_origins')->where('slug', 'colombia')->delete();
    }
};
