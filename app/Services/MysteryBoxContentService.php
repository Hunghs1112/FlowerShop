<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\App;

class MysteryBoxContentService
{
    public const KEY = 'mystery_box_content';

    public const KEY_EN = 'mystery_box_content_en';

    /**
     * Storage key holding admin overrides for the given locale.
     */
    public function settingKey(?string $locale = null): string
    {
        $locale = $locale ?: App::getLocale();

        return $locale === 'en' ? self::KEY_EN : self::KEY;
    }

    /**
     * Default content for a locale, sourced from the language files.
     */
    public function defaults(?string $locale = null): array
    {
        $locale = $locale ?: App::getLocale();

        return (array) trans('mystery.content', [], $locale);
    }

    /**
     * Resolved content for the current (or given) locale: language defaults
     * merged with any admin overrides stored for that locale.
     */
    public function get(?string $locale = null): array
    {
        $locale = $locale ?: App::getLocale();
        $saved = json_decode((string) Setting::get($this->settingKey($locale), ''), true);

        return is_array($saved)
            ? array_replace_recursive($this->defaults($locale), $saved)
            : $this->defaults($locale);
    }

    /**
     * Save admin overrides for a locale.
     */
    public function save(array $content, ?string $locale = null): void
    {
        Setting::set(
            $this->settingKey($locale),
            json_encode($content, JSON_UNESCAPED_UNICODE),
            'json'
        );
    }

    public function textList(string $value): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $value))));
    }

    public function budgetList(string $value): array
    {
        $budgets = [];

        foreach (preg_split('/\r\n|\r|\n/', $value) as $line) {
            [$key, $label] = array_pad(explode('|', $line, 2), 2, '');
            $key = trim($key);
            $label = trim($label);

            if ($key !== '' && $label !== '') {
                $budgets[] = ['value' => $key, 'label' => $label];
            }
        }

        return $budgets;
    }

    public function updateField(string $field, mixed $value, ?string $locale = null): array
    {
        $content = $this->get($locale);

        // Handle _text suffix: textarea fields store as array
        if (str_ends_with($field, '_text')) {
            $key = substr($field, 0, -5);
            if ($key === 'budgets') {
                $content[$key] = $this->budgetList($value);
            } else {
                $content[$key] = $this->textList($value);
            }
        } else {
            $content[$field] = $value;
        }

        $this->save($content, $locale);

        return $content;
    }
}
