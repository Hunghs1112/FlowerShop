<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class LibreTranslateService
{
    protected string $baseUrl;

    protected string $model;

    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.ollama.url', 'http://127.0.0.1:11434'), '/');
        $this->model = config('services.ollama.model', 'flowershop-translator');
        $this->timeout = (int) config('services.ollama.timeout', 120);
    }

    public function translate(
        string $text,
        string $source = 'vi',
        string $target = 'en',
        ?string $existingTranslation = null
    ): string {
        if (filled($existingTranslation)) {
            return $existingTranslation;
        }

        $translated = Http::timeout($this->timeout)
            ->post("{$this->baseUrl}/api/chat", [
                'model' => $this->model,
                'stream' => false,
                'think' => false,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "Translate faithfully from {$source} to {$target}. Return only the translation. Preserve formatting, names, numbers, and punctuation.",
                    ],
                    ['role' => 'user', 'content' => $text],
                ],
            ])
            ->throw()
            ->json('message.content');

        if (! is_string($translated) || $translated === '') {
            throw new RuntimeException('Ollama returned no translation.');
        }

        return $translated;
    }
}
