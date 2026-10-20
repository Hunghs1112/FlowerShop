<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Tests\TestCase;

class HomePageContentTest extends TestCase
{
    public function test_admin_can_auto_save_the_homepage_hero_description(): void
    {
        $content = '**Hoa tuyển chọn**, được chăm chút cho không gian của bạn. <script>alert(1)</script>';

        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->patchJson(route('admin.settings.updateField'), [
                'field' => 'home_hero_description',
                'value' => $content,
            ])
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertSame($content, Setting::get('home_hero_description'));
        $this->get('/')
            ->assertOk()
            ->assertSee('<strong>Hoa tuyển chọn</strong>', false)
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_admin_settings_has_a_homepage_content_tab(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->get(route('admin.settings.index'))
            ->assertOk()
            ->assertSee('data-tab="homepage"', false)
            ->assertSee('name="home_hero_description"', false);
    }

    public function test_homepage_hero_description_rejects_non_text_content(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->patchJson(route('admin.settings.updateField'), [
                'field' => 'home_hero_description',
                'value' => ['not text'],
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('value');
    }
}
