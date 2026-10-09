<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeasonalRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_seasonal_pages_and_old_links_work(): void
    {
        $pages = [
            '/mua-le-hoi' => 'Mùa lễ hội',
            '/mua-le-hoi/hoi-mua-thu' => 'Hội mùa thu',
            '/mua-le-hoi/halloween' => 'Halloween',
            '/mua-le-hoi/cay-thong-dan-mach' => 'Cây thông Đan Mạch',
            '/phu-kien-cay-thong' => 'Cây thông Đan Mạch',
        ];

        foreach ($pages as $url => $title) {
            $this->get($url)
                ->assertOk()
                ->assertSee($title)
                ->assertSee('seasonal-page', false)
                ->assertSee('navbar', false)
                ->assertSee('footer', false);
        }

        $this->get('/trang/mua-le-hoi')->assertRedirect('/mua-le-hoi');
        $this->get('/trang/phu-kien-cay-thong')->assertRedirect('/phu-kien-cay-thong');
    }

    public function test_tree_preorder_is_saved_and_invalid_input_is_rejected(): void
    {
        $payload = [
            'season_slug' => 'mua-le-hoi',
            'size' => '1,8 m',
            'accessories' => ['Bộ quả châu (12 quả)'],
            'addons' => ['Giao & dựng cây tại nhà'],
            'name' => 'Nguyễn An',
            'phone' => '0901234567',
            'address' => 'Quận 1, TP. Hồ Chí Minh',
        ];

        $this->postJson('/mua-le-hoi/dat-truoc', $payload)->assertCreated();
        $this->assertDatabaseHas('inquiries', [
            'name' => 'Nguyễn An',
            'phone' => '0901234567',
            'status' => 'new',
        ]);
        $this->assertStringContainsString('1,8 m', Inquiry::latest('id')->value('message'));

        $this->postJson('/mua-le-hoi/dat-truoc', [...$payload, 'phone' => 'invalid'])
            ->assertUnprocessable();
        $this->postJson('/mua-le-hoi/dat-truoc', [...$payload, 'size' => '5 m'])
            ->assertUnprocessable();
        $this->assertDatabaseCount('inquiries', 1);
    }
}
