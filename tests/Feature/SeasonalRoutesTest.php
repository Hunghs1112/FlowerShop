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
        foreach (['phu-kien-cay-thong', 'mua-le-hoi'] as $slug) {
            $response = $this->get("/$slug")->assertOk();

            $this->assertSame(
                hash_file('sha256', base_path("files/$slug.html")),
                hash('sha256', $response->getContent()),
            );
            $this->get("/trang/$slug")->assertRedirect("/$slug");
        }
    }

    public function test_tree_preorder_is_saved_and_invalid_input_is_rejected(): void
    {
        $payload = [
            'season_slug' => 'mua-le-hoi',
            'size' => '1,8 m',
            'accessories' => ['Bộ quả châu'],
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
