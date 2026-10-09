<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuidePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_guide_uses_editable_legacy_page_content(): void
    {
        Page::create([
            'title' => 'Hướng dẫn mua hàng',
            'slug' => 'huong-dan-mua-hang',
            'content' => "## Nội dung đã cập nhật\n\nBản hướng dẫn từ quản trị.",
            'is_active' => true,
        ]);

        $this->get(route('guide'))->assertOk()
            ->assertSee('Nội dung đã cập nhật')
            ->assertSee('Bản hướng dẫn từ quản trị.')
            ->assertDontSee('id="o1"', false);
    }

    public function test_guide_falls_back_to_designed_page_without_content(): void
    {
        $this->get(route('guide'))->assertOk()->assertSee('id="o1"', false);
    }

    public function test_admin_can_edit_guide_content_without_changing_its_legacy_slug(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $page = Page::create([
            'title' => 'Hướng dẫn mua hàng',
            'slug' => 'huong-dan-mua-hang',
            'content' => 'Old content',
            'is_active' => true,
        ]);

        $this->actingAs($admin)->get(route('admin.pages.edit', $page))->assertOk();
        $this->actingAs($admin)->patch(route('admin.pages.update', $page), [
            'title' => 'Hướng dẫn cập nhật',
            'content' => 'New guide content',
        ])->assertRedirect(route('admin.pages.index'));

        $this->assertSame('huong-dan-mua-hang', $page->fresh()->slug);
        $this->assertSame('New guide content', $page->fresh()->content);
        $this->actingAs($admin)->delete(route('admin.pages.destroy', $page))->assertNotFound();
    }
}
