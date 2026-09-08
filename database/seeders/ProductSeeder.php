<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Please run CategorySeeder first.');
            return;
        }

        $products = [
            ['name' => 'Hoa Hồng Đỏ Ecuador', 'price' => 850000, 'stock' => 25, 'description' => 'Hoa hồng đỏ nhập khẩu từ Ecuador, cánh to, thân dài 70cm, thích hợp làm quà tặng sang trọng', 'featured' => true],
            ['name' => 'Hoa Hồng Phớt Ohara', 'price' => 1200000, 'stock' => 15, 'description' => 'Hoa hồng Ohara Nhật Bản màu phớt pastel, cánh xoắn tròn đẹp, hương thơm nhẹ nhàng', 'featured' => true],
            ['name' => 'Hoa Ly Trắng Tinh Khôi', 'price' => 650000, 'stock' => 30, 'description' => 'Hoa ly trắng đài to, hương thơm đặc trưng, biểu tượng của sự thuần khiết và thanh lịch', 'featured' => true],
            ['name' => 'Hoa Hướng Dương Vàng', 'price' => 450000, 'stock' => 40, 'description' => 'Hoa hướng dương tươi sáng, biểu tượng của sự tươi vui và năng lượng tích cực', 'featured' => false],
            ['name' => 'Hoa Tulip Hà Lan Mix', 'price' => 750000, 'stock' => 20, 'description' => 'Hoa tulip nhập khẩu Hà Lan nhiều màu sắc, tươi mới và giữ lâu', 'featured' => true],
            ['name' => 'Hoa Cẩm Chướng Nhiều Màu', 'price' => 380000, 'stock' => 50, 'description' => 'Hoa cẩm chướng đa sắc màu, giữ tươi lâu, phù hợp cho nhiều dịp khác nhau', 'featured' => false],
            ['name' => 'Hoa Cẩm Tú Cầu Xanh', 'price' => 680000, 'stock' => 18, 'description' => 'Hoa cẩm tú cầu màu xanh tím đặc biệt, cụm hoa tròn đầy, sang trọng và quý phái', 'featured' => true],
            ['name' => 'Hoa Mẫu Đơn Cao Cấp', 'price' => 1500000, 'stock' => 10, 'description' => 'Hoa mẫu đơn cao cấp, cánh nhiều lớp, màu sắc rực rỡ, biểu tượng phú quý thịnh vượng', 'featured' => true],
            ['name' => 'Hoa Baby Tím Pastel', 'price' => 320000, 'stock' => 35, 'description' => 'Hoa baby tím pastel, nhẹ nhàng tinh tế, thích hợp làm hoa kết hợp hoặc hoa chính', 'featured' => false],
            ['name' => 'Hoa Đồng Tiền Nhiều Màu', 'price' => 420000, 'stock' => 38, 'description' => 'Hoa đồng tiền đa sắc, cánh mỏng đẹp, tươi lâu và dễ chăm sóc', 'featured' => false],
            ['name' => 'Hoa Lan Hồ Điệp Trắng', 'price' => 950000, 'stock' => 12, 'description' => 'Lan hồ điệp trắng tinh khôi, 7-9 bông, chậu gốm cao cấp, thích hợp làm quà tặng tân gia', 'featured' => true],
            ['name' => 'Bó Hoa Sinh Nhật Mix', 'price' => 580000, 'stock' => 28, 'description' => 'Bó hoa hỗn hợp nhiều loại hoa tươi theo mùa, bao bì đẹp mắt, kèm thiệp chúc mừng', 'featured' => false],
            ['name' => 'Giỏ Hoa Chúc Mừng', 'price' => 780000, 'stock' => 22, 'description' => 'Giỏ hoa tươi sang trọng, phối hợp nhiều loại hoa cao cấp, thích hợp khai trương', 'featured' => true],
            ['name' => 'Hoa Cát Tường Tím', 'price' => 340000, 'stock' => 45, 'description' => 'Hoa cát tường màu tím nhẹ nhàng, giữ tươi lâu, thích hợp cho mọi không gian', 'featured' => false],
            ['name' => 'Hộp Hoa Hồng Sáp 99 Bông', 'price' => 2500000, 'stock' => 8, 'description' => 'Hộp hoa hồng sáp cao cấp 99 bông, giữ mãi không tàn, quà tặng ý nghĩa cho người thương', 'featured' => true],
        ];

        foreach ($products as $productData) {
            // Skip if already exists
            $exists = Product::where('slug', Str::slug($productData['name']))->exists();
            if ($exists) {
                $this->command->info('Product already exists: ' . $productData['name']);
                continue;
            }

            $category = $categories->random();
            
            $product = Product::create([
                'category_id' => $category->id,
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'short_description' => $productData['description'],
                'is_featured' => $productData['featured'],
                'is_active' => true,
            ]);

            // Create a placeholder product image
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'placeholder.jpg',
                'sort_order' => 1,
                'is_primary' => true,
            ]);
            
            $this->command->info('Created product: ' . $productData['name']);
        }
    }
}
