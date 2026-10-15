<?php

namespace Tests\Feature;

use App\Models\FlowerOrigin;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminAutoSaveUploadTest extends TestCase
{
    public function test_flower_origin_upload_accepts_the_auto_save_payload(): void
    {
        Storage::fake('public');
        $flowerOrigin = FlowerOrigin::firstOrFail();
        $oldImage = $flowerOrigin->image;

        $this->postAutoSaveImage(route('admin.flower-origins.uploadImage', $flowerOrigin));

        $flowerOrigin->refresh();
        $this->assertNotSame($oldImage, $flowerOrigin->image);
        Storage::disk('public')->assertExists($flowerOrigin->image);
    }

    public function test_logo_upload_accepts_the_auto_save_payload(): void
    {
        Storage::fake('public');

        $this->postAutoSaveImage(route('admin.settings.uploadLogo'));

        $logo = Setting::where('key', 'site_logo')->value('value');
        $this->assertNotNull($logo);
        Storage::disk('public')->assertExists($logo);
    }

    private function postAutoSaveImage(string $url): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->postJson($url, [
                'images' => [UploadedFile::fake()->image('replacement.jpg')],
            ])
            ->assertOk()
            ->assertJson(['success' => true]);
    }
}
