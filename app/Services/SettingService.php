<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    /**
     * Get a setting value
     */
    public function get(string $key, $default = null)
    {
        return Setting::get($key, $default);
    }

    /**
     * Set a setting value
     */
    public function set(string $key, $value, string $type = 'text'): void
    {
        Setting::set($key, $value, $type);
    }

    /**
     * Get multiple settings at once
     */
    public function getMultiple(array $keys): array
    {
        $settings = [];

        foreach ($keys as $key) {
            $settings[$key] = $this->get($key);
        }

        return $settings;
    }

    /**
     * Get all settings
     */
    public function getAll(): array
    {
        return Cache::remember('all_settings', 3600, function () {
            return Setting::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Update multiple settings
     */
    public function updateMultiple(array $settings): void
    {
        foreach ($settings as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * Clear settings cache
     */
    public function clearCache(): void
    {
        Setting::clearCache();
    }

    /**
     * Get site info (commonly used settings)
     */
    public function getSiteInfo(): array
    {
        $settings = $this->getMultiple([
            'site_name',
            'site_description',
            'email',
            'phone',
            'address',
            'zalo_id',
            'zalo_url',
            'zalo_qr',
            'facebook_url',
            'instagram_url',
            'tiktok_url',
            'youtube_url',
            'social_youtube',
            'about',
        ]);

        return $settings;
    }
}
