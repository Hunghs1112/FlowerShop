<?php

namespace Tests\Feature;

use App\Models\User;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response
            ->assertStatus(200)
            ->assertSee(route('b2c'))
            ->assertSee('class="navbar"', false)
            ->assertSee('class="floating-contact-btn floating-contact-btn--zalo"', false)
            ->assertSee('class="floating-contact-btn floating-contact-btn--phone"', false)
            ->assertSee('id="floatingChatBtn"', false)
            ->assertSee('class="site-footer"', false);

        $this->assertSame(1, substr_count($response->getContent(), '<!DOCTYPE html>'));
        $this->assertStringContainsString('background:var(--bg)', $response->getContent());
        $this->assertSame(url('/b2b'), route('b2c'));
        $this->assertSame(url('/b2b'), route('b2c.store'));
        $this->get('/b2c')->assertRedirect('/b2b');
    }

    public function test_admin_still_sees_floating_contact_buttons(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->get('/')
            ->assertOk()
            ->assertSee('class="floating-contact-btn floating-contact-btn--zalo"', false)
            ->assertSee('class="floating-contact-btn floating-contact-btn--phone"', false)
            ->assertDontSee('id="floatingChatBtn"', false);
    }
}
