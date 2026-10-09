<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * SettingService — Read-oriented facade for frontend controllers.
 *
 * PHÂN BIỆT VAI TRÒ:
 *   SettingService    → dùng trong frontend controllers và AppServiceProvider
 *                       để đọc settings, lấy site info, cache tổng hợp.
 *   SettingRepository → dùng trong Admin\SettingController
 *                       để CRUD settings (setSetting, deleteByKey, getAllAsArray...).
 *
 * Hai class hoạt động độc lập, đều gọi Setting model trực tiếp.
 * Không nên merge vì mục đích sử dụng khác nhau:
 *   - Service tập trung vào read + cache phía frontend.
 *   - Repository tập trung vào write + admin operations.
 */
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
            'business_hours',
        ]);

        return $settings;
    }
}
