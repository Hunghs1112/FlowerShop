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
        $categories = Category::all()->keyBy('slug');

        // Available images (verified > 10KB)
        $availableImages = [
            'products/flowers-4.jpg',
            'products/flowers-4-new.jpg',
            'misc/featured-2.jpg',
            'misc/featured-2-new.jpg',
        ];

        $products = [
            // ─── Hoa Nhập Khẩu ───
            [
                'category' => 'hoa-nhap-khau',
                'name' => 'Hoa Hồng Đỏ Ecuador Nhập Khẩu',
                'slug' => 'hoa-hong-do-ecuador-nhap-khau',
                'price' => 850000,
                'stock' => 25,
                'short_description' => 'Hoa hồng đỏ nhập khẩu Ecuador, cánh hoa to tròn, thân dài 70cm. Biểu tượng tình yêu nồng nàn, thích hợp làm quà tặng sang trọng cho các dịp đặc biệt.',
                'is_featured' => true,
                'images' => [
                    ['path' => 'images/products/hoa-hong-do-ecuador.jpg', 'primary' => true],
                    ['path' => 'images/products/roses.jpg', 'primary' => false],
                ],
            ],
            [
                'category' => 'hoa-nhap-khau',
                'name' => 'Hoa Hồng Phớt Ohara Nhật Bản',
                'slug' => 'hoa-hong-phot-ohara-nhat-ban',
                'price' => 1200000,
                'stock' => 15,
                'short_description' => 'Hoa hồng Ohara Nhật Bản màu phớt pastel thanh lịch, cánh hoa xoắn tròn đặc trưng, hương thơm nhẹ nhàng. Bó hoa sang trọng dành cho người đặc biệt.',
                'is_featured' => true,
                'images' => [
                    ['path' => 'images/products/hoa-hong-phot-ohara.jpg', 'primary' => true],
                    ['path' => 'images/products/flowers-1.jpg', 'primary' => false],
                ],
            ],
            [
                'category' => 'hoa-nhap-khau',
                'name' => 'Hoa Tulip Hà Lan Mix Màu',
                'slug' => 'hoa-tulip-ha-lan-mix-mau',
                'price' => 750000,
                'stock' => 20,
                'short_description' => 'Hoa tulip nhập khẩu Hà Lan phối nhiều màu sắc tươi sáng. Tulip tượng trưng cho tình yêu hoàn hảo và sự lạc quan, tươi mới mỗi ngày.',
                'is_featured' => true,
                'images' => [
                    ['path' => 'images/products/hoa-tulip.jpg', 'primary' => true],
                    ['path' => 'images/products/flowers-2.jpg', 'primary' => false],
                ],
            ],
            [
                'category' => 'hoa-nhap-khau',
                'name' => 'Hoa Mẫu Đơn Cao Cấp Nhập Khẩu',
                'slug' => 'hoa-mau-don-cao-cap-nhap-khau',
                'price' => 1500000,
                'stock' => 10,
                'short_description' => 'Hoa mẫu đơn cao cấp nhập khẩu, cánh hoa nhiều lớp mịn màng, màu sắc rực rỡ. Biểu tượng của phú quý, thịnh vượng và may mắn.',
                'is_featured' => true,
                'images' => [
                    ['path' => 'images/products/hoa-mau-don.jpg', 'primary' => true],
                    ['path' => 'images/products/hoa-hong-phot-ohara.jpg', 'primary' => false],
                ],
            ],
            // ─── Hoa Tươi Mới ───
            [
                'category' => 'hoa-tuoi-moi',
                'name' => 'Hoa Ly Trắng Tinh Khôi',
                'slug' => 'hoa-ly-trang-tinh-khoi',
                'price' => 650000,
                'stock' => 30,
                'short_description' => 'Hoa ly trắng đài hoa to, cánh hoa mềm mại, hương thơm đặc trưng. Biểu tượng của sự thuần khiết, thanh lịch và tinh khiết — phù hợp cho mọi dịp.',
                'is_featured' => true,
                'images' => [
                    ['path' => 'images/products/hoa-ly-trang.jpg', 'primary' => true],
                    ['path' => 'images/products/flowers-3.jpg', 'primary' => false],
                ],
            ],
            [
                'category' => 'hoa-tuoi-moi',
                'name' => 'Hoa Hướng Dương Vàng Tươi Sáng',
                'slug' => 'hoa-huong-duong-vang-tuoi-sang',
                'price' => 450000,
                'stock' => 40,
                'short_description' => 'Hoa hướng dương tươi sáng rực rỡ, biểu tượng của sự tích cực, năng lượng và niềm vui. Món quà hoàn hảo để chúc mừng thành công.',
                'is_featured' => false,
                'images' => [
                    ['path' => 'images/products/hoa-huong-duong.jpg', 'primary' => true],
                    ['path' => 'images/products/flowers-5.jpg', 'primary' => false],
                ],
            ],
            [
                'category' => 'hoa-tuoi-moi',
                'name' => 'Hoa Cẩm Chướng Đa Sắc Màu',
                'slug' => 'hoa-cam-chuong-da-sac-mau',
                'price' => 380000,
                'stock' => 50,
                'short_description' => 'Hoa cẩm chướng đa sắc màu, giữ tươi lâu trên 10 ngày, phù hợp cho nhiều dịp từ sinh nhật đến kỷ niệm. Hoa mang ý nghĩa về sự yêu thương bền lâu.',
                'is_featured' => false,
                'images' => [
                    ['path' => 'images/products/hoa-cam-chuong.jpg', 'primary' => true],
                    ['path' => 'images/products/hoa-tulip.jpg', 'primary' => false],
                ],
            ],
            [
                'category' => 'hoa-tuoi-moi',
                'name' => 'Hoa Cẩm Tú Cầu Xanh Tím Quý Phái',
                'slug' => 'hoa-cam-tu-cau-xanh-tim-quy-phai',
                'price' => 680000,
                'stock' => 18,
                'short_description' => 'Hoa cẩm tú cầu màu xanh tím đặc biệt, cụm hoa tròn đầy kiểu dáng sang trọng. Biểu tượng của sự thịnh vượng, thành công và lòng biết ơn.',
                'is_featured' => true,
                'images' => [
                    ['path' => 'images/products/hoa-cam-tu-cau.jpg', 'primary' => true],
                    ['path' => 'images/products/hoa-hong-do-ecuador.jpg', 'primary' => false],
                ],
            ],
            // ─── Lan Hồ Điệp ───
            [
                'category' => 'lan-ho-diep',
                'name' => 'Chậu Lan Hồ Điệp Trắng Tinh Khôi',
                'slug' => 'chau-lan-ho-diep-trang-tinh-khoi',
                'price' => 950000,
                'stock' => 12,
                'short_description' => 'Chậu lan hồ điệp trắng tinh khôi 7-9 bông, chậu gốm cao cấp. Thích hợp làm quà tặng tân gia, khai trương, biếu ông bà. Trưng bày được 2-3 tháng.',
                'is_featured' => true,
                'images' => [
                    ['path' => 'images/products/flowers-6.jpg', 'primary' => true],
                    ['path' => 'images/products/hoa-hong-do-ecuador.jpg', 'primary' => false],
                ],
            ],
            [
                'category' => 'lan-ho-diep',
                'name' => 'Chậu Lan Hồ Điệp Hồng Phớt Cao Cấp',
                'slug' => 'chau-lan-ho-diep-phot-cao-cap',
                'price' => 1100000,
                'stock' => 8,
                'short_description' => 'Chậu lan hồ điệp màu hồng phớt thanh lịch, 9-12 bông, chậu sứ trắng cao cấp. Món quà sang trọng cho mẹ, vợ, người yêu.',
                'is_featured' => false,
                'images' => [
                    ['path' => 'images/products/hoa-hong-phot-ohara.jpg', 'primary' => true],
                    ['path' => 'images/products/flowers-3.jpg', 'primary' => false],
                ],
            ],
            // ─── Sinh Nhật ───
            [
                'category' => 'sinh-nhat',
                'name' => 'Bó Hoa Sinh Nhật Mix Nhiều Loại',
                'slug' => 'bo-hoa-sinh-nhat-mix-nhieu-loai',
                'price' => 580000,
                'stock' => 28,
                'short_description' => 'Bó hoa sinh nhật hỗn hợp nhiều loại hoa tươi theo mùa, bao bì giấy kraft đẹp mắt, kèm thiệp chúc mừng. Món quà hoàn hảo cho ngày sinh nhật đáng nhớ.',
                'is_featured' => false,
                'images' => [
                    ['path' => 'images/products/flowers-5.jpg', 'primary' => true],
                    ['path' => 'images/products/flowers-2.jpg', 'primary' => false],
                ],
            ],
            [
                'category' => 'sinh-nhat',
                'name' => 'Giỏ Hoa Sinh Nhật Hoa Hồng Và Baby',
                'slug' => 'gio-hoa-sinh-nhat-hoa-hong-va-baby',
                'price' => 720000,
                'stock' => 20,
                'short_description' => 'Giỏ hoa sinh nhật phối hợp hoa hồng đỏ và hoa baby trắng nhẹ nhàng. Giỏ mây tre trang nhã, thích hợp tặng bạn bè, đồng nghiệp.',
                'is_featured' => true,
                'images' => [
                    ['path' => 'images/products/roses.jpg', 'primary' => true],
                    ['path' => 'images/products/flowers-3.jpg', 'primary' => false],
                ],
            ],
            // ─── Khai Trương ───
            [
                'category' => 'khai-truong',
                'name' => 'Giỏ Hoa Khai Trương Sang Trọng Mix',
                'slug' => 'gio-hoa-khai-truong-sang-trong-mix',
                'price' => 780000,
                'stock' => 22,
                'short_description' => 'Giỏ hoa khai trương phối hợp nhiều loại hoa cao cấp với tông màu vàng - đỏ may mắn. Biểu tượng của sự thành công, phát đạt và thịnh vượng.',
                'is_featured' => true,
                'images' => [
                    ['path' => 'images/products/flowers-2.jpg', 'primary' => true],
                    ['path' => 'images/products/hoa-huong-duong.jpg', 'primary' => false],
                ],
            ],
            [
                'category' => 'khai-truong',
                'name' => 'Bó Hoa Khai Trương Hoa Hướng Dương',
                'slug' => 'bo-hoa-khai-truong-hoa-huong-duong',
                'price' => 650000,
                'stock' => 18,
                'short_description' => 'Bó hoa khai trương nổi bật với hoa hướng dương rực rỡ, kết hợp hoa cẩm chướng và lá xanh. Màu vàng tượng trưng cho tiền bạc và thành công.',
                'is_featured' => false,
                'images' => [
                    ['path' => 'images/products/hoa-huong-duong.jpg', 'primary' => true],
                    ['path' => 'images/products/hoa-cam-chuong.jpg', 'primary' => false],
                ],
            ],
            // ─── Cưới Hỏi ───
            [
                'category' => 'cuoi-hoi',
                'name' => 'Bó Hoa Cầm Tay Cô Dâu Hồng Phớt',
                'slug' => 'bo-hoa-cam-tay-co-dau-phot',
                'price' => 890000,
                'stock' => 15,
                'short_description' => 'Bó hoa cầm tay cô dâu phong cách hiện đại, phối hoa hồng phớt và gardenia, dây lụa mềm mại. Tinh tế, lãng mạn cho ngày trọng đại.',
                'is_featured' => true,
                'images' => [
                    ['path' => 'images/products/hoa-hong-phot-ohara.jpg', 'primary' => true],
                    ['path' => 'images/products/hoa-mau-don.jpg', 'primary' => false],
                ],
            ],
            [
                'category' => 'cuoi-hoi',
                'name' => 'Giỏ Hoa Trang Trí Đám Cưới Trắng',
                'slug' => 'gio-hoa-trang-tri-dam-cuoi-trang',
                'price' => 1200000,
                'stock' => 10,
                'short_description' => 'Giỏ hoa trắng trang trí đám cưới sang trọng, gồm hoa hồng trắng, cẩm tú cầu và hoa mẫu đơn. Thiết kế tinh xảo cho tiệc cưới, lễ hội.',
                'is_featured' => false,
                'images' => [
                    ['path' => 'images/products/hoa-ly-trang.jpg', 'primary' => true],
                    ['path' => 'images/products/hoa-mau-don.jpg', 'primary' => false],
                ],
            ],
            // ─── Chúc Mừng ───
            [
                'category' => 'chuc-mung',
                'name' => 'Giỏ Hoa Chúc Mừng Thành Công',
                'slug' => 'gio-hoa-chuc-mung-thanh-cong',
                'price' => 680000,
                'stock' => 20,
                'short_description' => 'Giỏ hoa chúc mừng phối hoa hướng dương và hoa cúc vàng rực rỡ, kèm lá xanh tươi tắn. Món quà hoàn hảo để chúc mừng thành công, vinh danh.',
                'is_featured' => false,
                'images' => [
                    ['path' => 'images/products/hoa-huong-duong.jpg', 'primary' => true],
                    ['path' => 'images/products/hoa-cam-chuong.jpg', 'primary' => false],
                ],
            ],
            [
                'category' => 'chuc-mung',
                'name' => 'Bó Hoa Chúc Mừng Tân Gia',
                'slug' => 'bo-hoa-chuc-mung-tan-gia',
                'price' => 750000,
                'stock' => 18,
                'short_description' => 'Bó hoa tân gia phối hoa ly trắng thanh lịch và hoa đồng tiền vàng tươi sáng. Mang đến lời chúc về sự thịnh vượng và bình an cho ngôi nhà mới.',
                'is_featured' => true,
                'images' => [
                    ['path' => 'images/products/hoa-ly-trang.jpg', 'primary' => true],
                    ['path' => 'images/products/hoa-huong-duong.jpg', 'primary' => false],
                ],
            ],
            // ─── Tình Yêu ───
            [
                'category' => 'tinh-yeu',
                'name' => 'Hộp Hoa Hồng Sáp 99 Bông Cao Cấp',
                'slug' => 'hop-hoa-hong-sap-99-bong-cao-cap',
                'price' => 2500000,
                'stock' => 8,
                'short_description' => 'Hộp hoa hồng sáp cao cấp 99 bông màu đỏ burgundy sang trọng. Giữ mãi không tàn, quà tặng ý nghĩa dành cho người bạn yêu thương nhất.',
                'is_featured' => true,
                'images' => [
                    ['path' => 'images/products/roses.jpg', 'primary' => true],
                    ['path' => 'images/products/hoa-hong-phot-ohara.jpg', 'primary' => false],
                ],
            ],
            [
                'category' => 'tinh-yeu',
                'name' => 'Bó Hoa Hồng Đỏ 36 Bông Tình Yêu',
                'slug' => 'bo-hoa-hong-do-36-bong-tinh-yeu',
                'price' => 1200000,
                'stock' => 12,
                'short_description' => 'Bó hoa hồng đỏ 36 bông Ecuador thân dài, gói giấy kraft đỏ sang trọng. Món quà tình yêu kinh điển, không thể thiếu cho ngày kỷ niệm.',
                'is_featured' => true,
                'images' => [
                    ['path' => 'images/products/hoa-hong-do-ecuador.jpg', 'primary' => true],
                    ['path' => 'images/products/roses.jpg', 'primary' => false],
                ],
            ],
            [
                'category' => 'tinh-yeu',
                'name' => 'Bó Hoa Hồng Phớt Baby Breath Nhẹ Nhàng',
                'slug' => 'bo-hoa-hong-phot-baby-breath-nhe-nhang',
                'price' => 550000,
                'stock' => 25,
                'short_description' => 'Bó hoa hồng phớt nhạt kết hợp hoa baby trắng tinh khôi, dây ruy băng lụa hồng. Bó hoa ngọt ngào dành cho Valentine, kỷ niệm tháng ngày yêu nhau.',
                'is_featured' => false,
                'images' => [
                    ['path' => 'images/products/hoa-hong-phot-ohara.jpg', 'primary' => true],
                    ['path' => 'images/products/hoa-ly-trang.jpg', 'primary' => false],
                ],
            ],
        ];

        foreach ($products as $productData) {
            $categorySlug = $productData['category'];
            $images = $productData['images'];
            unset($productData['category'], $productData['images']);

            $category = $categories->get($categorySlug);
            if (!$category) {
                $this->command->warn("Category not found: {$categorySlug}");
                continue;
            }

            $product = Product::updateOrCreate(
                ['slug' => $productData['slug']],
                array_merge($productData, [
                    'category_id' => $category->id,
                    'is_active' => true,
                ])
            );

            // Replace product images
            $product->productImages()->delete();
            foreach ($images as $idx => $img) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $img['path'],
                    'sort_order' => $idx + 1,
                    'is_primary' => $img['primary'] ?? ($idx === 0),
                ]);
            }
        }
    }
}
