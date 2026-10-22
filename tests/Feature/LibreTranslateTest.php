<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\LibreTranslateController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class LibreTranslateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Route::post('/_test/admin/translate', [LibreTranslateController::class, 'translate']);
        $this->actingAs(User::factory()->create(['role' => 'admin']));
    }

    public function test_translation_success(): void
    {
        Http::fake(['*/translate' => Http::response(['translatedText' => 'Red rose'])]);

        $this->postJson('/_test/admin/translate', [
            'text' => 'Hồng đỏ',
            'source' => 'vi',
            'target' => 'en',
        ])->assertOk()->assertJson(['success' => true, 'translated' => 'Red rose']);
    }

    public function test_translation_is_admin_only(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'customer']));

        $this->postJson('/_test/admin/translate', [
            'text' => 'Hồng đỏ',
            'source' => 'vi',
            'target' => 'en',
        ])->assertForbidden();
    }

    public function test_translation_http_error_is_safe(): void
    {
        Http::fake(['*/translate' => Http::response(['error' => 'failure'], 500)]);

        $this->postJson('/_test/admin/translate', [
            'text' => 'Hồng đỏ',
            'source' => 'vi',
            'target' => 'en',
        ])->assertStatus(502)->assertJson(['success' => false, 'error' => 'Translation service failed.']);
    }

    public function test_translation_timeout_is_reported_as_gateway_timeout(): void
    {
        Http::fake(fn () => throw new ConnectionException('timeout'));

        $this->postJson('/_test/admin/translate', [
            'text' => 'Hồng đỏ',
            'source' => 'vi',
            'target' => 'en',
        ])->assertStatus(504)->assertJson(['success' => false]);
    }

    public function test_existing_translation_is_not_overwritten_or_sent_remotely(): void
    {
        Http::preventStrayRequests();

        $this->postJson('/_test/admin/translate', [
            'text' => 'Hồng đỏ',
            'source' => 'vi',
            'target' => 'en',
            'existing_translation' => 'Existing English',
        ])->assertOk()->assertJson(['translated' => 'Existing English']);

        Http::assertNothingSent();
    }
}
