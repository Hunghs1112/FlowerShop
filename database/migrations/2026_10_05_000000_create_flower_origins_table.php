<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flower_origins', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->unsignedSmallInteger('map_x');
            $table->unsignedSmallInteger('map_y');
            $table->string('country');
            $table->string('flower');
            $table->string('latin');
            $table->string('region');
            $table->string('coordinate');
            $table->string('image');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('flower_origins')->insert([
            ['slug' => 'netherlands', 'map_x' => 500, 'map_y' => 127, 'country' => 'Hà Lan', 'flower' => 'Tulip', 'latin' => 'Tulipa gesneriana', 'region' => 'Aalsmeer', 'coordinate' => '52.26°N, 4.76°E', 'image' => 'images/products/product-4.jpg', 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'ecuador', 'map_x' => 280, 'map_y' => 300, 'country' => 'Ecuador', 'flower' => 'Hoa hồng', 'latin' => 'Rosa hybrida', 'region' => 'Cayambe', 'coordinate' => '0.04°N, 78.14°W', 'image' => 'images/products/product-1.jpg', 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'south-africa', 'map_x' => 548, 'map_y' => 389, 'country' => 'Nam Phi', 'flower' => 'Protea vua', 'latin' => 'Protea cynaroides', 'region' => 'Western Cape', 'coordinate' => '33.92°S, 18.42°E', 'image' => 'images/products/product-2.jpg', 'sort_order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'china', 'map_x' => 773, 'map_y' => 188, 'country' => 'Trung Quốc', 'flower' => 'Mao lương', 'latin' => 'Ranunculus asiaticus', 'region' => 'Vân Nam', 'coordinate' => '24.88°N, 102.83°E', 'image' => 'images/instagram/flowers-2.jpg', 'sort_order' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'japan', 'map_x' => 879, 'map_y' => 174, 'country' => 'Nhật Bản', 'flower' => 'Cúc zinnia', 'latin' => 'Zinnia elegans', 'region' => 'Tokyo', 'coordinate' => '35.68°N, 139.69°E', 'image' => 'images/products/hoa-cam-chuong.jpg', 'sort_order' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'malaysia', 'map_x' => 773, 'map_y' => 306, 'country' => 'Malaysia', 'flower' => 'Cúc mẫu đơn', 'latin' => 'Chrysanthemum morifolium', 'region' => 'Cameron Highlands', 'coordinate' => '4.47°N, 101.38°E', 'image' => 'images/products/product-3.jpg', 'sort_order' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'vietnam', 'map_x' => 798, 'map_y' => 274, 'country' => 'Việt Nam', 'flower' => 'Lan hồ điệp', 'latin' => 'Phalaenopsis', 'region' => 'Đà Lạt', 'coordinate' => '11.94°N, 108.44°E', 'image' => 'images/instagram/flowers-6.jpg', 'sort_order' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['slug' => 'new-zealand', 'map_x' => 957, 'map_y' => 449, 'country' => 'New Zealand', 'flower' => 'Mẫu đơn', 'latin' => 'Paeonia lactiflora', 'region' => 'Canterbury', 'coordinate' => '43.53°S, 172.64°E', 'image' => 'images/products/hoa-mau-don.jpg', 'sort_order' => 8, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('flower_origins');
    }
};
