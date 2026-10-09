<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_loads_when_contact_settings_are_missing(): void
    {
        $this->get('/ve-chung-toi')
            ->assertOk()
            ->assertDontSee('Undefined array key');
    }

    public function test_passport_links_use_matched_category_slugs_and_fallback_for_unmatched_countries(): void
    {
        Category::create(['name' => 'Ecuador', 'slug' => 'ecuador-flowers', 'is_active' => true]);
        Category::create(['name' => 'Colombia', 'slug' => 'colombia-flowers', 'is_active' => true]);

        $this->get('/ve-chung-toi')
            ->assertOk()
            ->assertSee('"ec":"' . str_replace('/', '\\/', route('products.index', ['category' => 'ecuador-flowers'])) . '"', false)
            ->assertSee('"co":"' . str_replace('/', '\\/', route('products.index', ['category' => 'colombia-flowers'])) . '"', false)
            ->assertSee('"jp":"' . str_replace('/', '\\/', route('products.index')) . '"', false);
    }
}
