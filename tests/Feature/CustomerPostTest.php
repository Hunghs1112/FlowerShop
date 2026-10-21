<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CustomerPostTest extends TestCase
{
    public function test_customer_can_publish_a_post_under_their_name(): void
    {
        $customer = User::factory()->create(['name' => 'Lan', 'is_active' => true]);
        Post::create(['title' => 'Hoa cu', 'slug' => 'hoa-cu', 'content' => 'Cu', 'category' => 'cam-hung']);

        $response = $this->actingAs($customer)->post(route('blog.store'), [
            'title' => 'Hoa cu',
            'excerpt' => 'Mot cau chuyen',
            'category' => 'du-an',
            'content' => 'Noi dung bai viet',
            'author_id' => User::factory()->create()->id,
            'is_published' => false,
        ]);

        $post = Post::where('title', 'Hoa cu')->where('author_id', $customer->id)->firstOrFail();

        $response->assertRedirect(route('blog.show', $post->slug));
        $this->assertSame('hoa-cu-2', $post->slug);
        $this->assertTrue($post->is_published);
        $this->get(route('blog.show', $post->slug))->assertSee('Tác giả: Lan');
    }

    public function test_empty_category_falls_back_to_project_posts(): void
    {
        Post::create([
            'title' => 'Du an doi tac',
            'slug' => 'du-an-doi-tac',
            'content' => 'Noi dung',
            'category' => 'du-an',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->get(route('blog.index', ['category' => 'cham-hoa']))
            ->assertOk()
            ->assertSee('Du an doi tac')
            ->assertSee('các dự án đã hợp tác', false);
    }

    public function test_guest_cannot_open_or_submit_the_post_form(): void
    {
        $this->get(route('blog.create'))->assertRedirect(route('login'));
        $this->post(route('blog.store'), [])->assertRedirect(route('login'));
    }

    public function test_customer_can_upload_content_images_repeatedly(): void
    {
        Storage::fake('public');
        $customer = User::factory()->create(['is_active' => true]);

        foreach (['first.jpg', 'second.jpg'] as $name) {
            $response = $this->actingAs($customer)->postJson(route('blog.content-image'), [
                'image' => UploadedFile::fake()->image($name),
            ]);

            $path = str_replace('/storage/', '', $response->json('url'));
            $response->assertOk()->assertJsonStructure(['url']);
            Storage::disk('public')->assertExists($path);
        }
    }

    public function test_content_image_upload_rejects_non_images(): void
    {
        Storage::fake('public');
        $customer = User::factory()->create(['is_active' => true]);

        $this->actingAs($customer)->postJson(route('blog.content-image'), [
            'image' => UploadedFile::fake()->create('file.txt', 10, 'text/plain'),
        ])->assertUnprocessable()->assertJsonValidationErrors('image');
    }
}
