<?php

namespace Database\Seeders;

use App\Models\Popup;
use Illuminate\Database\Seeder;

class PopupSeeder extends Seeder
{
    public function run(): void
    {
        $popups = [
            [
                'id_key' => '20-10',
                'is_active' => false,
                'theme' => 'rose',
                'eyebrow' => '20/10 · NGÀY PHỤ NỮ VIỆT NAM',
                'route' => 'LNT → HAN',
                'title' => 'Hoa tặng người phụ nữ của bạn',
                'text' => 'Đặt trước để Lâm Nhiên Thảo chuẩn bị bó hoa và giao đúng ngày 20/10.',
                'bullets' => [
                    'Chọn mẫu có sẵn hoặc để LNT thiết kế theo ngân sách',
                    '[Khung giờ giao hàng ngày 20/10]',
                    '[Ưu đãi đặt sớm – nếu có]'
                ],
                'start_date' => '2026-10-08',
                'end_date' => '2026-10-20',
                'countdown' => '2026-10-20 00:00:00',
                'countdown_label' => 'CÒN',
                'image' => '',
                'image_alt' => 'Bó mẫu đơn hồng',
                'stamp' => '20/10',
                'stamp_sub' => 'PRE-ORDER',
                'cta_label' => 'Đặt hoa 20/10',
                'cta_link' => '/san-pham',
                'cta2' => 'zalo',
                'cta2_label' => '',
                'cta2_link' => '',
                'note' => 'Số lượng mỗi mẫu có hạn.',
                'teaser' => '🌷 Đặt hoa 20/10',
                'sort_order' => 1,
            ],
            [
                'id_key' => 'cay-thong',
                'is_active' => false,
                'theme' => 'nordic',
                'eyebrow' => 'GIÁNG SINH · MỞ ĐẶT TRƯỚC',
                'route' => 'CPH → HAN',
                'title' => 'Đặt trước cây thông Đan Mạch',
                'text' => 'Thông Nordmann nhập từ Đan Mạch. Số lượng mỗi chuyến có hạn, đặt trước để giữ cây.',
                'bullets' => [
                    'Nhiều chiều cao, chọn theo không gian nhà bạn',
                    'Bộ phụ kiện và dịch vụ trang trí đi kèm',
                    '[Hạn chót đặt trước]'
                ],
                'start_date' => '2026-11-01',
                'end_date' => '2026-12-20',
                'countdown' => '2026-12-25 00:00:00',
                'countdown_label' => 'ĐẾN GIÁNG SINH',
                'image' => '',
                'image_alt' => '',
                'stamp' => 'XMAS',
                'stamp_sub' => 'PRE-ORDER',
                'cta_label' => 'Đặt trước cây thông',
                'cta_link' => '/mua-le-hoi#thong',
                'cta2' => 'zalo',
                'cta2_label' => '',
                'cta2_link' => '',
                'note' => '',
                'teaser' => '🎄 Đặt trước cây thông',
                'sort_order' => 2,
            ],
        ];

        foreach ($popups as $popup) {
            Popup::updateOrCreate(
                ['id_key' => $popup['id_key']],
                $popup
            );
        }
    }
}
