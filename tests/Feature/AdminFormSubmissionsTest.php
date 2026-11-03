<?php

namespace Tests\Feature;

use App\Models\B2cInquiry;
use App\Models\NewsletterSubscription;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFormSubmissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_and_update_b2b_submissions_and_view_newsletter_subscriptions(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $inquiry = B2cInquiry::create([
            'business_type' => 'florist',
            'contact_name' => 'Nguyễn Hoa',
            'contact_email' => 'hoa@example.com',
            'business_name' => 'Tiệm Hoa',
            'address' => 'Hà Nội',
            'phone' => '0901234567',
            'years_in_business' => 3,
            'social_media' => 'https://example.com',
            'tax_code' => '0123456789',
            'vat_email' => 'vat@example.com',
            'business_license' => 'GP-123',
            'status' => 'new',
        ]);
        NewsletterSubscription::create(['email' => 'news@example.com']);
        Order::create([
            'status' => 'new',
            'customer_name' => 'Khách đặt hàng',
            'customer_phone' => '0909999999',
            'subtotal' => 100000,
            'total' => 100000,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.b2b-inquiries.index'))
            ->assertOk()
            ->assertSee('Tiệm Hoa')
            ->assertSee(route('admin.newsletter-subscriptions.index'), false)
            ->assertSee('admin-nav-section-title">Đơn Hàng</div>', false)
            ->assertSee('admin-nav-text">Đơn đặt hàng</span>', false)
            ->assertSee('data-admin-badge="orders">1</span>', false)
            ->assertSee('data-admin-badge="b2b">1</span>', false)
            ->assertDontSee('title="Thông Báo"', false);

        $this->actingAs($admin)
            ->get(route('admin.b2b-inquiries.show', $inquiry))
            ->assertOk()
            ->assertSee('GP-123');

        $this->actingAs($admin)
            ->patch(route('admin.b2b-inquiries.updateStatus', $inquiry), ['status' => 'contacted'])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('b2c_inquiries', ['id' => $inquiry->id, 'status' => 'contacted']);

        $this->actingAs($admin)
            ->get(route('admin.newsletter-subscriptions.index'))
            ->assertOk()
            ->assertSee('news@example.com')
            ->assertSee('data-admin-badge="orders">1</span>', false)
            ->assertDontSee('data-admin-badge="b2b"', false);
    }
}
