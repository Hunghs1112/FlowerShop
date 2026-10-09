<?php

return [
    'hub' => [
        'eyebrow' => 'MÙA LỄ HỘI',
        'title' => 'Chuyến bay mùa lễ',
        'intro' => 'Mỗi mùa lễ là một chuyến bay đặc biệt. Chọn chuyến của bạn: sắc thu ấm áp, đêm Halloween huyền bí, hay cây thông bay về từ Bắc Âu.',
    ],
    'seasons' => [
        [
            'id' => 'thu', 'code' => 'AUT', 'theme' => 'autumn',
            'name' => 'Hội mùa thu', 'tagline' => 'Chuyến bay mùa lá đỏ', 'status' => 'Đang bay', 'date' => null,
            'intro' => 'Những gam màu ấm của mùa thu: đỏ rượu vang, cam đất và vàng nắng.',
            'products' => [
                ['name' => 'Hồng Freedom đỏ trầm', 'origin' => 'Ecuador', 'code' => 'UIO', 'image' => '/images/flower-origins/ec.jpg', 'link' => '/san-pham', 'badge' => 'TÔNG THU'],
                ['name' => 'Pincushion vàng nắng', 'origin' => 'Nam Phi', 'code' => 'CPT', 'image' => '/images/flower-origins/za.jpg', 'link' => '/san-pham', 'badge' => 'MỚI VỀ'],
                ['name' => 'Ly hổ cam đốm', 'origin' => 'Trung Quốc', 'code' => 'KMG', 'image' => '/images/flower-origins/cn.jpg', 'link' => '/san-pham', 'badge' => null],
            ],
            'cta' => ['label' => 'Xem bộ sưu tập mùa thu', 'link' => '/san-pham'],
        ],
        [
            'id' => 'halloween', 'code' => 'HLW', 'theme' => 'night',
            'name' => 'Halloween', 'tagline' => 'Chuyến bay đêm 31/10', 'status' => 'Mở đặt trước', 'date' => '2026-10-31',
            'intro' => 'Đêm 31/10, những đóa hoa khoác lên mình sắc cam, đỏ thẫm và tím đêm.',
            'products' => [
                ['name' => 'Pincushion cam lửa', 'origin' => 'Nam Phi', 'code' => 'CPT', 'image' => '/images/flower-origins/za.jpg', 'link' => '/san-pham', 'badge' => 'ĐÊM HỘI'],
                ['name' => 'Hồng đỏ thẫm', 'origin' => 'Ecuador', 'code' => 'UIO', 'image' => '/images/flower-origins/ec.jpg', 'link' => '/san-pham', 'badge' => null],
            ],
            'cta' => ['label' => 'Đặt hoa Halloween', 'link' => '/san-pham'],
        ],
        [
            'id' => 'thong', 'code' => 'CPH', 'theme' => 'nordic',
            'name' => 'Cây thông Đan Mạch', 'tagline' => 'Chuyến bay từ Bắc Âu · CPH → HAN', 'status' => 'Mở đặt trước', 'date' => '2026-12-25',
            'intro' => 'Thông Nordmann nhập từ Đan Mạch, tán dày, lá mềm, xanh lâu và hương gỗ thông dịu nhẹ cho mùa Giáng sinh.',
            'tree' => [
                'deadline' => '2026-11-20', 'arrival' => 'Theo lịch hàng về được xác nhận', 'deposit' => 'Nhân viên sẽ xác nhận mức cọc',
                'sizes' => [
                    ['label' => '1,2 m', 'cm' => 120, 'price' => null],
                    ['label' => '1,5 m', 'cm' => 150, 'price' => null],
                    ['label' => '1,8 m', 'cm' => 180, 'price' => null],
                    ['label' => '2,1 m', 'cm' => 210, 'price' => null],
                    ['label' => '2,4 m', 'cm' => 240, 'price' => null],
                ],
                'addons' => ['Giao & dựng cây tại nhà', 'Trang trí tại nhà theo bộ đã chọn', 'Thu gom cây sau mùa lễ'],
                'accessories' => ['Bộ quả châu', 'Dây đèn LED 10 m', 'Ngôi sao đỉnh cây', 'Ruy băng nhung', 'Chân đế giữ nước'],
                'faq' => [
                    ['question' => 'Khi nào cây về và được giao?', 'answer' => 'Lịch giao được xác nhận riêng với từng đơn đặt trước.'],
                    ['question' => 'Đặt cọc và thanh toán như thế nào?', 'answer' => 'Nhân viên sẽ liên hệ để xác nhận cây, lịch giao và mức cọc trước khi thanh toán.'],
                ],
            ],
            'cta' => ['label' => 'Đặt trước cây thông', 'link' => '#dat-truoc'],
        ],
    ],
];
