<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeasonalRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_seasonal_pages_and_old_links_work(): void
    {
        foreach (['phu-kien-cay-thong', 'mua-le-hoi'] as $slug) {
            $this->get("/$slug")->assertOk();
            $this->get("/trang/$slug")->assertRedirect("/$slug");
        }
    }
}
