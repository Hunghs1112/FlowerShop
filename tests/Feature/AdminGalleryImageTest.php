<?php

namespace Tests\Feature;

use App\Models\GalleryImage;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminGalleryImageTest extends TestCase
{
    public function test_gallery_image_upload_accepts_the_auto_save_payload(): void
    {
        Storage::fake('public');

        $galleryImage = GalleryImage::create([
            'image' => 'gallery-images/original.jpg',
            'alt_text' => 'Original image',
        ]);

        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->postJson(route('admin.gallery-images.uploadImage', $galleryImage), [
                'images' => [UploadedFile::fake()->image('replacement.jpg')],
            ])
            ->assertOk()
            ->assertJson(['success' => true]);

        $galleryImage->refresh();
        $this->assertNotSame('gallery-images/original.jpg', $galleryImage->image);
        Storage::disk('public')->assertExists($galleryImage->image);
    }
}
