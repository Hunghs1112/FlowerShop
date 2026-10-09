<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class NewsletterSubscriptionTest extends TestCase
{
    public function test_valid_email_is_normalized_and_persisted(): void
    {
        $this->from('/')
            ->post(route('newsletter.store'), ['email' => '  Reader@Example.COM '])
            ->assertRedirect('/')
            ->assertSessionHas('newsletter_success');

        $this->assertDatabaseHas('newsletter_subscriptions', [
            'email' => 'reader@example.com',
        ]);
        $this->get('/')->assertSee('role="status"', false);
    }

    public function test_duplicate_email_is_not_persisted_twice(): void
    {
        $this->post(route('newsletter.store'), ['email' => 'reader@example.com']);
        $this->post(route('newsletter.store'), ['email' => ' READER@example.com ']);

        $this->assertDatabaseCount('newsletter_subscriptions', 1);
    }

    public function test_invalid_email_is_rejected(): void
    {
        $this->followingRedirects()
            ->from('/')
            ->post(route('newsletter.store'), ['email' => 'not-an-email'])
            ->assertOk()
            ->assertSee('role="alert"', false);

        $this->assertDatabaseCount('newsletter_subscriptions', 0);
    }

    public function test_footer_form_points_to_named_route(): void
    {
        $this->assertTrue(Route::has('newsletter.store'));

        $this->get('/')
            ->assertOk()
            ->assertSee('action="'.route('newsletter.store').'"', false);
    }
}
