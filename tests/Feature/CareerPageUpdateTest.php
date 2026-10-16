<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Tests\TestCase;

class CareerPageUpdateTest extends TestCase
{
    public function test_admin_can_autosave_career_content_as_json(): void
    {
        $content = json_decode(file_get_contents(resource_path('data/career.json')), true, flags: JSON_THROW_ON_ERROR);
        $content['masthead'] = 'LNT CAREERS';

        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->putJson(route('admin.career.update'), [
                'content' => $content,
                'is_active' => true,
            ])
            ->assertOk()
            ->assertJson(['success' => true]);

        $saved = json_decode(Page::where('slug', 'tuyen-dung')->value('content'), true, flags: JSON_THROW_ON_ERROR);
        $this->assertSame('LNT CAREERS', $saved['masthead']);
    }
}
