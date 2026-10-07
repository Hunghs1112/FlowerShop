<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PolicyPageSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'chinh-sach-bao-mat' => 'Chính sách bảo mật',
            'chinh-sach-cua-chung-toi' => 'Chính sách của chúng tôi',
            'chinh-sach-giao-hang' => 'Chính sách giao hàng',
            'dieu-khoan-dich-vu' => 'Điều khoản dịch vụ',
        ] as $slug => $title) {
            Page::firstOrCreate(
                ['slug' => $slug],
                ['title' => $title, 'content' => '', 'is_active' => true],
            );
        }
    }
}
