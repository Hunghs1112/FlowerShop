<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use App\Models\Inquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeliveryPolicyPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_six_information_pages_render_without_page_records(): void
    {
        foreach (['policy.delivery', 'policy.baomat', 'policy.ours', 'policy.terms', 'guide', 'contact'] as $name) {
            $this->get(route($name))->assertOk();
        }
    }

    public function test_delivery_policy_uses_static_content_even_when_a_page_record_exists(): void
    {
        Page::create([
            'title' => 'Old delivery page',
            'slug' => 'chinh-sach-giao-hang',
            'content' => 'Database-only policy text',
            'is_active' => true,
        ]);

        $this->get('/chinh-sach-giao-hang')
            ->assertOk()
            ->assertSee('08 CÁC MỤC')
            ->assertSee('Giao trong ngày: xác nhận trước 14:00')
            ->assertDontSee('Database-only policy text');

        $this->get('/trang/chinh-sach-giao-hang')
            ->assertRedirect('/chinh-sach-giao-hang');
    }

    public function test_static_policy_record_cannot_be_edited_in_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $page = Page::create([
            'title' => 'Old delivery page',
            'slug' => 'chinh-sach-giao-hang',
            'content' => 'Old content',
            'is_active' => true,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.pages.index'))
            ->assertOk()
            ->assertDontSee('Old delivery page');
        $this->get(route('admin.pages.edit', $page))->assertNotFound();
        $this->patch(route('admin.pages.updateField', $page), ['field' => 'content', 'value' => 'Changed'])
            ->assertNotFound();
        $this->assertSame('Old content', $page->fresh()->content);
    }

    public function test_contact_form_still_saves_a_message(): void
    {
        $this->post(route('contact.store'), [
            'name' => 'Test Visitor',
            'phone' => '0869308993',
            'email' => 'visitor@example.com',
            'message' => 'Please call me back.',
        ])->assertRedirect();

        $this->assertSame('Please call me back.', Inquiry::firstOrFail()->message);
    }
}
