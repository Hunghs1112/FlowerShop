<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_submission_is_saved_and_emailed_to_configured_recipient(): void
    {
        Mail::shouldReceive('raw')->once();
        Setting::set('email_notification_enabled', 1, 'boolean');
        Setting::set('contact_form_email', 'contact@lamnhienthao.com');

        $response = $this->post('/lien-he', [
            'name' => 'Khách thử nghiệm',
            'phone' => '0901234567',
            'email' => 'customer@example.com',
            'zalo_id' => '0901234567',
            'message' => 'Tôi cần tư vấn.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('inquiries', [
            'phone' => '0901234567',
            'message' => 'Tôi cần tư vấn.',
        ]);
    }
}
