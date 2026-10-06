<?php

namespace Tests\Feature;

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
            ->assertSee('class="navbar"', false)
            ->assertSee('id="floatingChatBtn"', false)
            ->assertSee('class="site-footer"', false);

        $this->assertSame(1, substr_count($response->getContent(), '<!DOCTYPE html>'));
    }
}
