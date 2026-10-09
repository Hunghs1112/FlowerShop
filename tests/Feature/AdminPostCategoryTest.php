<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class AdminPostCategoryTest extends TestCase
{
    public function test_admin_can_update_post_category(): void
    {
        $post = Post::create(['title' => 'Flowers', 'slug' => 'flowers', 'content' => 'A story about flowers.', 'category' => 'vung-dat']);

        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->put(route('admin.posts.update', $post), [
                'title' => 'Flowers',
                'content' => 'A story about flowers.',
                'category' => 'hau-truong',
                'status' => 'draft',
            ])->assertRedirect(route('admin.posts.index'));

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'category' => 'hau-truong']);
    }

    public function test_admin_cannot_save_an_unknown_post_category(): void
    {
        $post = Post::create(['title' => 'Flowers', 'slug' => 'flowers', 'content' => 'A story about flowers.', 'category' => 'cam-hung']);

        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->from(route('admin.posts.edit', $post))
            ->put(route('admin.posts.update', $post), [
                'title' => 'Flowers',
                'content' => 'A story about flowers.',
                'category' => 'unknown',
                'status' => 'draft',
            ])->assertSessionHasErrors('category');

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'category' => 'cam-hung']);
    }
}
