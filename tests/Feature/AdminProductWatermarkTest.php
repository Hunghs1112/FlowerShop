<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProductWatermarkTest extends TestCase
{
    public function test_admin_can_save_product_watermark_settings(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->putJson(route('admin.watermark.update'), [
                'variant' => 'white',
                'position' => 'mc',
                'size' => 30,
                'margin' => 5.5,
                'opacity' => 45,
            ])
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertSame('white', Setting::get('product_watermark_variant'));
        $this->assertSame('mc', Setting::get('product_watermark_position'));
        $this->assertSame('30', Setting::get('product_watermark_size'));
        $this->assertSame('5.5', Setting::get('product_watermark_margin'));
        $this->assertSame('45', Setting::get('product_watermark_opacity'));
    }

    public function test_invalid_product_watermark_settings_are_rejected(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->putJson(route('admin.watermark.update'), [
                'variant' => 'purple',
                'position' => 'outside',
                'size' => 100,
                'margin' => -1,
                'opacity' => 0,
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['variant', 'position', 'size', 'margin', 'opacity']);
    }

    public function test_admin_can_replace_and_remove_the_product_watermark_logo(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.watermark.logo.upload'), [
                'logo' => UploadedFile::fake()->image('watermark.png', 600, 400),
            ])
            ->assertOk()
            ->assertJson(['success' => true]);

        $path = Setting::get('product_watermark_logo');
        Storage::disk('public')->assertExists($path);

        $this->actingAs($admin)
            ->deleteJson(route('admin.watermark.logo.delete'))
            ->assertOk()
            ->assertJson(['success' => true]);

        Storage::disk('public')->assertMissing($path);
        $this->assertSame('', Setting::get('product_watermark_logo'));
    }
}
