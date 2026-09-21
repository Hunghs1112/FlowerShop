<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sinh Nhật',
                'slug' => 'sinh-nhat',
                'description' => 'Bó hoa tươi đẹp dành cho ngày sinh nhật, mang đến niềm vui và bất ngờ cho người thân',
                'icon' => '🎂',
                'image' => 'categories/sinh-nhat-birthday-flowers.jpg',
                'sort_order' => 1,
            ],
            [
                'name' => 'Khai Trương',
                'slug' => 'khai-truong',
                'description' => 'Giỏ hoa, bó hoa khai trương sang trọng, mang lại may mắn và thành công cho doanh nghiệp',
                'icon' => '🎊',
                'image' => 'categories/category-1.jpg',
                'sort_order' => 2,
            ],
            [
                'name' => 'Cưới Hỏi',
                'slug' => 'cuoi-hoi',
                'description' => 'Hoa cầu kỳ, hoa cầm tay và trang trí đám cưới tinh tế, làm đẹp cho ngày trọng đại',
                'icon' => '💒',
                'image' => 'categories/cuoi-hoi-wedding-flowers.jpg',
                'sort_order' => 3,
            ],
            [
                'name' => 'Chúc Mừng',
                'slug' => 'chuc-mung',
                'description' => 'Hoa chúc mừng thành công, vinh danh, tân gia - gửi đến lời chúc tốt đẹp nhất',
                'icon' => '🎉',
                'image' => 'categories/chuc-mung-congratulations.jpg',
                'sort_order' => 4,
            ],
            [
                'name' => 'Tình Yêu',
                'slug' => 'tinh-yeu',
                'description' => 'Hoa hồng lãng mạn và những bó hoa tình yêu ngọt ngào dành cho người bạn yêu thương',
                'icon' => '💕',
                'image' => 'products/roses.jpg',
                'sort_order' => 5,
            ],
            [
                'name' => 'Hoa Nhập Khẩu',
                'slug' => 'hoa-nhap-khau',
                'description' => 'Hoa nhập khẩu cao cấp từ Ecuador, Hà Lan, Nhật Bản - đẳng cấp và sang trọng',
                'icon' => '🌹',
                'image' => 'categories/hoa-nhap-khau-imported-flowers.jpg',
                'sort_order' => 6,
            ],
            [
                'name' => 'Hoa Tươi Mới',
                'slug' => 'hoa-tuoi-moi',
                'description' => 'Hoa tươi theo mùa, nhập mới mỗi ngày từ vườn hoa địa phương và vùng trồng uy tín',
                'icon' => '🌷',
                'image' => 'categories/hoa-tuoi-moi-fresh-flowers.jpg',
                'sort_order' => 7,
            ],
            [
                'name' => 'Lan Hồ Điệp',
                'slug' => 'lan-ho-diep',
                'description' => 'Chậu lan hồ điệp cao cấp, tượng trưng cho sự sang trọng và phú quý, trưng bày lâu dài',
                'icon' => '🪻',
                'image' => 'categories/lan-ho-diep-orchid.jpg',
                'sort_order' => 8,
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => $cat['slug']],
                [
                    'name' => $cat['name'],
                    'slug' => $cat['slug'],
                    'description' => $cat['description'],
                    'icon' => $cat['icon'],
                    'image' => $cat['image'] ?? null,
                    'sort_order' => $cat['sort_order'],
                    'is_active' => true,
                ]
            );
        }
    }
}
