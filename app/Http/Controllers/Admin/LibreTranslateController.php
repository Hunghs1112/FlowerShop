<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TranslateRequest;
use App\Services\LibreTranslateService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;

class LibreTranslateController extends Controller
{
    public function __construct(protected LibreTranslateService $translateService) {}

    public function translate(TranslateRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try {
            $translated = $this->translateService->translate(
                $validated['text'],
                $validated['source'],
                $validated['target'],
                $validated['existing_translation'] ?? null
            );

            return response()->json([
                'success' => true,
                'translated' => $translated,
                'source_language' => $validated['source'],
                'target_language' => $validated['target'],
            ]);
        } catch (ConnectionException) {
            return response()->json([
                'success' => false,
                'error' => 'Translation service timed out or is unavailable.',
            ], 504);
        } catch (RequestException|\RuntimeException) {
            return response()->json([
                'success' => false,
                'error' => 'Translation service failed.',
            ], 502);
        }
    }

    public function backfill(): JsonResponse
    {
        $exitCode = Artisan::call('translations:backfill');

        return response()->json([
            'success' => $exitCode === 0,
            'output' => Artisan::output(),
        ], $exitCode === 0 ? 200 : 502);
    }
}
