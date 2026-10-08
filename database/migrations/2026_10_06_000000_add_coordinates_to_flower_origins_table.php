<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('flower_origins', function (Blueprint $table) {
            $table->string('country_code', 5)->nullable()->after('country');
            $table->string('lat', 20)->nullable()->after('country_code');
            $table->string('lon', 20)->nullable()->after('lat');
        });

        $now = now();
        DB::table('flower_origins')->insertOrIgnore([
            ['slug' => 'hn', 'map_x' => 600, 'map_y' => 280, 'country' => 'Hà Nội · Điểm đến', 'flower' => 'Lâm Nhiên Thảo', 'latin' => 'Nơi chín chuyến hoa cùng hạ cánh, được chăm chút rồi trao đến không gian của bạn.', 'region' => 'Hà Nội', 'coordinate' => '21.03°N, 105.85°E', 'image' => 'images/flower-origins/hn.jpg', 'country_code' => 'hn', 'lat' => '21.03', 'lon' => '105.85', 'sort_order' => 0, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['slug' => 'colombia', 'map_x' => 280, 'map_y' => 283, 'country' => 'Colombia', 'flower' => 'Cẩm chướng', 'latin' => 'Dianthus caryophyllus', 'region' => 'Sabana de Bogotá', 'coordinate' => '4.71°N, 74.07°W', 'image' => 'images/flower-origins/co.jpg', 'country_code' => 'co', 'lat' => '4.71', 'lon' => '-74.07', 'sort_order' => 9, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Seed lat/lon from coordinate strings and set country_codes
        $updates = [
            'hn'           => ['country_code' => 'hn', 'lat' => '21.03', 'lon' => '105.85'],
            'netherlands'  => ['country_code' => 'nl', 'lat' => '52.26', 'lon' => '4.76'],
            'ecuador'      => ['country_code' => 'ec', 'lat' => '0.04',  'lon' => '-78.14'],
            'south-africa' => ['country_code' => 'za', 'lat' => '-33.92','lon' => '18.42'],
            'china'        => ['country_code' => 'cn', 'lat' => '24.88', 'lon' => '102.83'],
            'japan'        => ['country_code' => 'jp', 'lat' => '35.68', 'lon' => '139.69'],
            'malaysia'     => ['country_code' => 'my', 'lat' => '4.47',  'lon' => '101.38'],
            'vietnam'      => ['country_code' => 'vn', 'lat' => '11.94', 'lon' => '108.44'],
            'new-zealand'  => ['country_code' => 'nz', 'lat' => '-43.53','lon' => '172.64'],
            'colombia'     => ['country_code' => 'co', 'lat' => '4.71', 'lon' => '-74.07'],
        ];

        foreach ($updates as $slug => $vals) {
            DB::table('flower_origins')->where('slug', $slug)->update($vals);
        }

        $legacyImages = [
            'netherlands' => 'images/products/product-4.jpg', 'ecuador' => 'images/products/product-1.jpg',
            'south-africa' => 'images/products/product-2.jpg', 'china' => 'images/instagram/flowers-2.jpg',
            'japan' => 'images/products/hoa-cam-chuong.jpg', 'malaysia' => 'images/products/product-3.jpg',
            'vietnam' => 'images/instagram/flowers-6.jpg', 'new-zealand' => 'images/products/hoa-mau-don.jpg',
        ];
        foreach ($legacyImages as $slug => $legacyImage) {
            $code = $updates[$slug]['country_code'];
            DB::table('flower_origins')->where('slug', $slug)->where('image', $legacyImage)
                ->update(['image' => "images/flower-origins/{$code}.jpg"]);
        }
    }

    public function down(): void
    {
        Schema::table('flower_origins', function (Blueprint $table) {
            $table->dropColumn(['country_code', 'lat', 'lon']);
        });
    }
};
