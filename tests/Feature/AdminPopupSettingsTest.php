<?php

namespace Tests\Feature;

use App\Models\Popup;
use App\Models\Setting;
use App\Models\User;
use Tests\TestCase;

class AdminPopupSettingsTest extends TestCase
{
    public function test_admin_saves_popup_and_shared_display_settings(): void
    {
        $response = $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->post(route('admin.popups.store'), [
                'id_key' => 'tet-2027',
                'title' => 'Tết 2027',
                'start_date' => '2027-01-01',
                'end_date' => '2027-02-28',
                'popup_delay' => 7,
                'popup_frequency' => 'session',
                'popup_zalo' => '090 123 4567',
            ]);

        $response->assertRedirect(route('admin.popups.index'));
        $this->assertDatabaseHas('popups', ['id_key' => 'tet-2027']);
        $this->assertSame('7', Setting::get('popup_delay'));
        $this->assertSame('session', Setting::get('popup_frequency'));
        $this->assertSame('090 123 4567', Setting::get('popup_zalo'));
    }

    public function test_invalid_shared_settings_do_not_create_a_popup(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->post(route('admin.popups.store'), [
                'id_key' => 'invalid-settings',
                'title' => 'Invalid',
                'start_date' => '2027-01-01',
                'end_date' => '2027-02-28',
                'popup_delay' => 61,
                'popup_frequency' => 'sometimes',
                'popup_zalo' => 'not-a-phone',
            ])
            ->assertSessionHasErrors(['popup_delay', 'popup_frequency', 'popup_zalo']);

        $this->assertDatabaseMissing('popups', ['id_key' => 'invalid-settings']);
    }

    public function test_forced_preview_includes_an_inactive_future_popup_without_exposing_it_normally(): void
    {
        Popup::create([
            'id_key' => 'future-preview',
            'title' => 'Future preview',
            'start_date' => '2030-01-01',
            'end_date' => '2030-01-31',
            'is_active' => false,
        ]);

        $this->get('/')->assertDontSee('future-preview');
        $this->get('/?popup=future-preview')->assertSee('future-preview');
    }
}
