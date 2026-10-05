<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeliveryPolicyPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_markdown_policy_headings_render_as_eight_sections(): void
    {
        Page::create([
            'title' => 'Chính sách giao hàng',
            'slug' => 'chinh-sach-giao-hang',
            'content' => "# CHÍNH SÁCH GIAO HÀNG\n\nGiới thiệu.\n\n## 01. KHU VỰC GIAO HÀNG\nNội dung 1.\n\n## 02. THỜI GIAN GIAO HÀNG\nNội dung 2.\n\n## 03. PHÍ GIAO HÀNG\nNội dung 3.\n\n## 04. QUY TRÌNH GIAO HÀNG\nNội dung 4.\n\n## 05. TIẾP NHẬN VÀ KIỂM TRA HOA\nNội dung 5.\n\n## 06. YÊU CẦU ĐẶC BIỆT\nNội dung 6.\n\n## 07. GIAO HÀNG KHÔNG THÀNH CÔNG\nNội dung 7.\n\n## 08. LIÊN HỆ\nNội dung 8.",
            'is_active' => true,
        ]);

        $response = $this->get('/trang/chinh-sach-giao-hang');

        $response->assertOk()
            ->assertSee('08 CÁC MỤC')
            ->assertDontSee('09 CÁC MỤC')
            ->assertSee('Giao trong ngày: xác nhận trước 14:00');
        $this->assertSame(8, substr_count($response->getContent(), 'class="policy-gate"'));
    }
}
