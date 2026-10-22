<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mystery Box — nội dung cấu hình (quản trị có thể chỉnh sửa bản tiếng Việt)
    |--------------------------------------------------------------------------
    | Dùng cho MysteryBoxContentService và các view mystery-box/*.
    */

    'content' => [
        'hero_title' => 'Hộp Hoa Bí Ẩn',
        'breadcrumb_home' => 'Trang chủ',
        'breadcrumb_mystery' => 'Hộp Hoa Bí Ẩn',
        'hero_description' => 'Để LNT chọn hoa, bạn giữ lại niềm vui bất ngờ',
        'intro_title' => 'Khám Phá Điều Bất Ngờ',
        'intro_description' => 'Hãy cho chúng tôi biết một vài sở thích, LNT sẽ chuẩn bị một hộp hoa thật đặc biệt dành riêng cho bạn.',
        'step_labels' => ['Phong cách', 'Màu sắc', 'Sở thích', 'Ngân sách', 'Bất ngờ', 'Ghi chú', 'Xác nhận'],
        'style_title' => 'Chọn Phong Cách',
        'styles' => ['Thanh lịch', 'Lãng mạn', 'Tự nhiên', 'Tối giản', 'Sang trọng'],
        'color_title' => 'Chọn Màu Sắc (có thể chọn nhiều)',
        'colors' => ['Trắng', 'Kem', 'Hồng', 'Xanh', 'Đỏ', 'Pastel', 'Không giới hạn'],
        'preference_title' => 'Sở Thích Về Hoa',
        'preferences' => ['Nhiều hoa', 'Ít hoa', 'Nhiều lá', 'Nhẹ nhàng', 'Nổi bật', 'Tự nhiên'],
        'budget_title' => 'Ngân Sách',
        'budgets' => [
            ['value' => '500k-1M', 'label' => '500.000đ - 1.000.000đ'],
            ['value' => '1M-2M', 'label' => '1.000.000đ - 2.000.000đ'],
            ['value' => '2M-5M', 'label' => '2.000.000đ - 5.000.000đ'],
            ['value' => '5M+', 'label' => 'Trên 5.000.000đ'],
        ],
        'surprise_title' => 'Mức Độ Bất Ngờ',
        'surprise_levels' => ['Bất ngờ hoàn toàn', 'Bất ngờ một phần', 'Muốn giữ một vài yêu cầu'],
        'note_title' => 'Ghi Chú',
        'name_label' => 'Họ và tên',
        'phone_label' => 'Số điện thoại',
        'email_label' => 'Email (tùy chọn)',
        'request_label' => 'Yêu cầu riêng',
        'request_placeholder' => 'Ví dụ: không dùng hoa ly, giao vào buổi sáng...',
        'confirm_title' => 'Xác Nhận Mystery Box',
        'selected_info_title' => 'Thông Tin Đã Chọn',
        'style_summary_label' => 'Phong cách:',
        'color_summary_label' => 'Bảng màu:',
        'preference_summary_label' => 'Sở thích:',
        'budget_summary_label' => 'Ngân sách:',
        'surprise_summary_label' => 'Mức độ bất ngờ:',
        'disclaimer' => 'Mỗi Mystery Box là một thiết kế độc bản. Hoa thực tế có thể thay đổi theo mùa nhưng luôn đảm bảo tinh thần và ngân sách bạn đã chọn.',
        'success_page_title' => 'Yêu Cầu Đã Được Gửi',
        'success_page_description' => 'Cảm ơn bạn đã tin tưởng LNT',
        'success_title' => 'Đã Nhận Yêu Cầu Của Bạn',
        'success_request_id_label' => 'Mã yêu cầu:',
        'success_message' => 'LNT sẽ kiểm tra hoa và xác nhận lại với bạn trước khi chuẩn bị đơn.',
        'success_contact_message' => 'Chúng tôi sẽ liên hệ với bạn qua số điện thoại',
        'success_summary_title' => 'Thông Tin Yêu Cầu',
        'success_style_label' => 'Phong cách',
        'success_color_label' => 'Bảng màu',
        'success_preference_label' => 'Sở thích',
        'success_budget_label' => 'Ngân sách',
        'success_surprise_label' => 'Mức độ bất ngờ',
        'success_note_label' => 'Ghi chú',
        'success_home_label' => 'Về trang chủ',
        'previous_label' => 'Quay lại',
        'next_label' => 'Tiếp theo',
        'submit_label' => 'Xác nhận yêu cầu',
    ],

    /*
    |--------------------------------------------------------------------------
    | Mystery Box — chuỗi giao diện & JavaScript
    |--------------------------------------------------------------------------
    */

    'ui' => [
        'page_title' => 'Hộp hoa bí ẩn · Lâm Nhiên Thảo',
        'hero_title' => 'Hộp hoa bí ẩn',
        'hero_lead' => 'Tám món đồ đang ẩn mình trong căn phòng bí mật. Mỗi món giữ một điều bạn muốn gửi gắm cho hộp hoa: tông màu, loài hoa, phong cách, sở thích… Tìm đủ, rồi dùng chiếc chìa khoá cuối cùng để khoá căn phòng lại.',
        'hint_button' => '💡 Gợi ý',
        'reveal_button' => 'Hiện tất cả món đồ',
        'seal_button' => 'Niêm phong & gửi hộp hoa',
        'aria_secret_room' => 'Căn phòng bí mật. Tìm 6 món đồ ẩn.',
        'aria_hidden_item' => 'Món đồ ẩn',
        'aria_items_list' => 'Các món đồ cần tìm',
        'privacy_note' => 'Thông tin nhận hàng chỉ dùng để xử lý đơn',
        'flowers' => ['Mẫu đơn', 'Tulip', 'Mao lương', 'Hồng Ecuador', 'Protea', 'Lan hồ điệp', 'Cẩm chướng', 'Cúc Malaysia', 'Ly', 'Không có yêu cầu'],

        'fields' => [
            'color' => [
                'obj' => 'Bảng màu',
                'label' => 'Tông màu hoa',
                'help' => 'Chọn tối đa 3 tông màu bạn muốn.',
            ],
            'flower' => [
                'obj' => 'Sách thực vật',
                'label' => 'Loại hoa đặc biệt',
                'help' => 'Loài hoa bạn mong có trong hộp, nếu có.',
            ],
            'style' => [
                'obj' => 'Khung tranh',
                'label' => 'Phong cách',
                'help' => 'Bạn muốn hộp hoa mang cảm giác nào?',
            ],
            'interest' => [
                'obj' => 'Đĩa nhạc',
                'label' => 'Sở thích',
                'help' => 'Người nhận (hoặc bạn) yêu thích điều gì? LNT sẽ dựa vào đó để chọn hoa và chi tiết đi kèm.',
                'extra' => 'Kể thêm một chút (không bắt buộc)',
            ],
            'budget' => [
                'obj' => 'Heo đất',
                'label' => 'Ngân sách',
                'help' => 'Chọn mức ngân sách cho hộp hoa.',
            ],
            'surprise' => [
                'obj' => 'Hộp quà nhỏ',
                'label' => 'Mức độ bất ngờ',
                'help' => 'Bạn muốn bất ngờ đến đâu?',
            ],
            'note' => [
                'obj' => 'Cuốn sổ',
                'label' => 'Lưu ý',
                'help' => 'Dị ứng phấn hoa, màu hay loài hoa muốn tránh, dịp tặng, lời nhắn kèm thiệp…',
            ],
            'confirm' => [
                'obj' => 'Chiếc chìa khoá',
                'label' => 'Xác nhận',
                'help' => 'Thông tin nhận hàng. Chìa khoá cuối cùng để khoá căn phòng.',
            ],
        ],

        'miss_messages' => ['Không phải đây…', 'Thử chỗ khác nhé', 'Hmm…'],
        'sealed_text' => 'Đã niêm phong ✓',
        'noted_text' => 'Đã ghi lại ✓',
        'no_selection' => 'Bạn chưa chọn sở thích nào. LNT sẽ tự do sáng tạo.',
        'tap_to_choose' => 'Chạm để chọn',
        'not_found' => 'Chưa tìm thấy',
        'found_label' => 'Đã tìm thấy, chưa chọn.',
        'stored_label' => 'Đã cất giữ.',
        'required_label' => 'bắt buộc',
        'hint_label' => 'Chưa tìm thấy, chạm để xem gợi ý.',
        'hidden_item_aria' => 'Món đồ ẩn',

        'contact_name' => 'Họ và tên *',
        'contact_phone' => 'Số điện thoại / Zalo *',
        'contact_address' => 'Địa chỉ nhận hoa *',
        'contact_date' => 'Ngày nhận mong muốn *',
        'contact_note' => 'Lưu ý thêm (không bắt buộc)',
        'contact_note_placeholder' => 'Dị ứng phấn hoa, màu hay loài hoa muốn tránh, dịp tặng, lời nhắn kèm thiệp…',
        'consent_text' => 'Tôi đã đọc',
        'consent_link' => 'chính sách đổi trả',
        'consent_tail' => 'và đồng ý để LNT liên hệ xác nhận đơn.',

        'panel_kicker' => 'BẠN ĐÃ TÌM THẤY',
        'later_button' => 'Để sau',
        'keep_button' => 'Cất giữ',
        'lock_button' => 'Khoá căn phòng',

        'err_max_items' => 'Chọn tối đa :max mục.',
        'err_min_choice' => 'Hãy chọn ít nhất một lựa chọn.',
        'err_required_fields' => 'Vui lòng điền đủ các thông tin có dấu *.',
        'err_invalid_phone' => 'Số điện thoại chưa đúng.',
        'err_consent' => 'Vui lòng xác nhận đã đọc chính sách.',
        'err_missing' => 'Còn thiếu: :list. Hãy tìm món đồ tương ứng trong phòng.',

        'status_found' => 'Đã tìm thấy :found/:total món đồ · đã cất giữ :filled điều',
        'status_ready' => ' · sẵn sàng niêm phong',
        'err_send_failed' => 'Không thể gửi yêu cầu.',
        'err_network' => 'Không thể kết nối. Vui lòng thử lại.',
        'extra_note_prefix' => 'Sở thích thêm: ',
    ],

    /*
    |--------------------------------------------------------------------------
    | Mystery Box — trang thành công
    |--------------------------------------------------------------------------
    */

    'success' => [
        'heading' => 'Yêu Cầu Đã Được Gửi',
        'subheading' => 'Cảm ơn bạn đã tin tưởng LNT',
        'title' => 'Đã Nhận Yêu Cầu Của Bạn',
        'request_id_label' => 'Mã yêu cầu:',
        'message' => 'LNT sẽ kiểm tra hoa và xác nhận lại với bạn trước khi chuẩn bị đơn.',
        'contact_message' => 'Chúng tôi sẽ liên hệ với bạn qua số điện thoại',
        'summary_title' => 'Thông Tin Yêu Cầu',
        'style_label' => 'Phong cách',
        'color_label' => 'Bảng màu',
        'preference_label' => 'Sở thích',
        'budget_label' => 'Ngân sách',
        'surprise_label' => 'Mức độ bất ngờ',
        'note_label' => 'Ghi chú',
        'home_label' => 'Về trang chủ',
        'no_note' => 'Không có',
    ],
];
