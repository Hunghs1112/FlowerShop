<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeliveryPolicyPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_policy_pages_keep_default_content_without_overrides(): void
    {
        foreach (['policy.delivery', 'policy.baomat', 'policy.ours', 'policy.terms'] as $route) {
            $this->get(route($route))->assertOk();
        }
        $this->get(route('policy.delivery'))->assertSee('14:00');
    }

    public function test_policy_pages_render_admin_content_safely(): void
    {
        Page::create([
            'title' => 'Updated delivery policy',
            'slug' => 'chinh-sach-giao-hang',
            'content' => '',
            'policy_intro' => 'New introduction',
            'policy_updated_at_display' => 'October 2026',
            'policy_content_override' => "## New section\n\nNew policy copy\n\n<script>alert(1)</script> [unsafe](javascript:alert(1))",
            'is_active' => true,
        ]);

        $this->get(route('policy.delivery'))
            ->assertOk()
            ->assertSee('Updated delivery policy')
            ->assertSee('New introduction')
            ->assertSee('New section')
            ->assertSee('New policy copy')
            ->assertDontSee('<div class="toolbar">', false)
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertDontSee('javascript:alert(1)', false);
    }

    public function test_admin_can_update_policy_content_but_cannot_change_or_delete_its_slug(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $page = Page::create([
            'title' => 'Delivery policy',
            'slug' => 'chinh-sach-giao-hang',
            'content' => '',
            'is_active' => true,
        ]);

        $this->actingAs($admin)->get(route('admin.pages.index'))
            ->assertOk()->assertSee('Delivery policy');
        $this->get(route('admin.pages.edit', $page))->assertOk()->assertSee('policy_content_override');
        $this->patch(route('admin.pages.updateField', $page), [
            'field' => 'policy_content_override', 'value' => '## Admin content',
        ])->assertOk();
        $this->assertSame('## Admin content', $page->fresh()->policy_content_override);

        $this->patch(route('admin.pages.update', $page), [
            'title' => 'Updated title', 'slug' => 'custom-slug', 'content' => '',
        ])->assertSessionHasErrors('slug');
        $this->delete(route('admin.pages.destroy', $page))->assertNotFound();
        $this->assertSame('chinh-sach-giao-hang', $page->fresh()->slug);
    }
}
