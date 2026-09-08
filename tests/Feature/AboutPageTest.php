<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_loads_when_contact_settings_are_missing(): void
    {
        $this->get('/ve-chung-toi')
            ->assertOk()
            ->assertDontSee('Undefined array key');
    }
}
