<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use Tests\TestCase;

class CareerApplicationTest extends TestCase
{
    public function test_visitor_can_submit_an_open_career_application(): void
    {
        $this->postJson(route('career.store'), [
            'position' => 0,
            'name' => 'Nguyen Van A',
            'year' => 2000,
            'phone' => '0901234567',
            'email' => 'applicant@example.com',
            'note' => 'I would like to apply.',
        ])->assertCreated();

        $this->assertDatabaseHas('inquiries', [
            'type' => 'career_application',
            'name' => 'Nguyen Van A',
            'email' => 'applicant@example.com',
        ]);
    }
}
