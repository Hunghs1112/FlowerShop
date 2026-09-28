<?php

namespace App\Services;

use App\Models\Setting;

class MysteryBoxContentService
{
    public const KEY = 'mystery_box_content';

    public function defaults(): array
    {
        return [
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
        ];
    }

    public function get(): array
    {
        $saved = json_decode((string) Setting::get(self::KEY, ''), true);

        return is_array($saved)
            ? array_replace_recursive($this->defaults(), $saved)
            : $this->defaults();
    }

    public function save(array $content): void
    {
        Setting::set(self::KEY, json_encode($content, JSON_UNESCAPED_UNICODE), 'json');
    }

    public function textList(string $value): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $value))));
    }

    public function budgetList(string $value): array
    {
        $budgets = [];

        foreach (preg_split('/\r\n|\r|\n/', $value) as $line) {
            [$key, $label] = array_pad(explode('|', $line, 2), 2, '');
            $key = trim($key);
            $label = trim($label);

            if ($key !== '' && $label !== '') {
                $budgets[] = ['value' => $key, 'label' => $label];
            }
        }

        return $budgets;
    }
}
