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
        Storage::fake('public');
        $customer = User::factory()->create(['name' => 'Lan', 'is_active' => true]);
        Post::create(['title' => 'Hoa cu', 'slug' => 'hoa-cu', 'content' => 'Cu', 'category' => 'cam-hung']);

        $response = $this->actingAs($customer)->post(route('blog.store'), [
            'title' => 'Hoa cu',
            'excerpt' => 'Mot cau chuyen',
            'category' => 'du-an',
            'content' => 'Noi dung bai viet',
            'thumbnail' => UploadedFile::fake()->image('thumbnail.jpg'),
            'author_id' => User::factory()->create()->id,
            'is_published' => false,
        ]);

        $post = Post::where('title', 'Hoa cu')->where('author_id', $customer->id)->firstOrFail();

        $response->assertRedirect(route('blog.show', $post->slug));
        $this->assertSame('hoa-cu-2', $post->slug);
        $this->assertTrue($post->is_published);
        Storage::disk('public')->assertExists($post->thumbnail);
        $this->get(route('blog.show', $post->slug))->assertSee('Tác giả: Lan');
    }

    public function test_customer_post_requires_a_thumbnail(): void
    {
        $customer = User::factory()->create(['is_active' => true]);

        $this->actingAs($customer)->post(route('blog.store'), [
            'title' => 'Bai viet khong anh',
            'category' => 'cam-hung',
            'content' => 'Noi dung',
        ])->assertSessionHasErrors('thumbnail');

        $this->assertDatabaseMissing('posts', ['title' => 'Bai viet khong anh']);
    }

    public function test_empty_category_falls_back_to_customer_feedback(): void
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
            ->assertSee('feedback từ khách hàng', false);
    }

    public function test_home_and_blog_use_configured_display_order(): void
    {
        $auto = Post::create([
            'title' => 'Automatic', 'slug' => 'automatic', 'content' => 'Content', 'category' => 'cam-hung',
            'is_published' => true, 'published_at' => now(), 'sort_order' => 0,
        ]);
        $third = Post::create([
            'title' => 'Third', 'slug' => 'third', 'content' => 'Content', 'category' => 'cam-hung',
            'is_published' => true, 'published_at' => now()->subDay(), 'sort_order' => 30,
        ]);
        $first = Post::create([
            'title' => 'First', 'slug' => 'first', 'content' => 'Content', 'category' => 'cam-hung',
            'is_published' => true, 'published_at' => now()->subDays(2), 'sort_order' => 10,
        ]);

        $expected = [$first->id, $third->id, $auto->id];

        $this->get(route('home'))->assertViewHas('latestPosts', fn ($posts) => $posts->modelKeys() === $expected);
        $this->get(route('blog.index'))->assertViewHas('posts', fn ($posts) => $posts->getCollection()->modelKeys() === $expected);
    }

    public function test_empty_feedback_category_shows_the_standard_empty_state(): void
    {
        $this->get(route('blog.index', ['category' => 'du-an']))
            ->assertOk()
            ->assertSee('Chuyên mục này sẽ sớm có những câu chuyện đầu tiên.');
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
