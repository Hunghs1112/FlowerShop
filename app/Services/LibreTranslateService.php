<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class LibreTranslateService
{
    protected string $baseUrl;

    protected ?string $apiKey;

    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.libretranslate.url', 'http://127.0.0.1:5000'), '/');
        $this->apiKey = config('services.libretranslate.api_key');
        $this->timeout = (int) config('services.libretranslate.timeout', 5);
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

        $body = [
            'q' => $text,
            'source' => $source,
            'target' => $target,
            'format' => 'text',
        ];
        if ($this->apiKey) {
            $body['api_key'] = $this->apiKey;
        }

        $translated = Http::timeout($this->timeout)
            ->post("{$this->baseUrl}/translate", $body)
            ->throw()
            ->json('translatedText');

        if (! is_string($translated) || $translated === '') {
            throw new RuntimeException('LibreTranslate returned no translation.');
        }

        return $translated;
    }
}
