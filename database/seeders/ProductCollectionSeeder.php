<?php

namespace Database\Seeders;

use App\Models\ProductCollection;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductCollectionSeeder extends Seeder
{
    public function run(): void
    {
        if (ProductCollection::exists()) {
            return;
        }

        $red = ProductCollection::create([
            'name' => 'Hoa tông đỏ',
            'criterion' => 'Hoa có sắc đỏ, hồng đậm, rượu vang',
            'accent_color' => '#7A1F2B',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $pastel = ProductCollection::create([
            'name' => 'Hoa tông pastel',
            'criterion' => 'Sắc nhẹ nhàng, kem, hồng phấn, tím lavender',
            'accent_color' => '#E8C5C5',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // Gắn các sản phẩm active vào, phân chia theo tên để tạo mẫu nhanh
        $products = Product::active()->orderBy('name')->get();

        $redIds = $products->filter(fn ($p) =>
            preg_match('/đỏ|hồng đậm|red|burgundy|rượu/i', $p->name)
        )->take(8)->pluck('id')->all();

        $pastelIds = $products->filter(fn ($p) =>
            preg_match('/pastel|hồng nhạt|cream|kem|lavender|tím nhạt|trắng|white/i', $p->name)
        )->take(8)->pluck('id')->all();

        if (empty($redIds)) {
            $redIds = $products->take(min(4, $products->count()))->pluck('id')->all();
        }
        if (empty($pastelIds)) {
            $pastelIds = $products->slice(2, 4)->pluck('id')->all();
        }

        $red->products()->sync(collect($redIds)->mapWithKeys(fn ($id, $i) => [$id => ['sort_order' => $i]])->all());
        $pastel->products()->sync(collect($pastelIds)->mapWithKeys(fn ($id, $i) => [$id => ['sort_order' => $i]])->all());
    }
}
