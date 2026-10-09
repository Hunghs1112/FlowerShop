<?php

namespace App\Repositories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Setting Repository — Write-oriented layer for Admin\SettingController.
 *
 * PHÂN BIỆT VAI TRÒ:
 *   SettingRepository → dùng trong Admin\SettingController để CRUD settings
 *                       (setSetting, deleteByKey, getAllAsArray, getByKey...).
 *   SettingService    → dùng trong frontend controllers để đọc và cache settings.
 *
 * Hai class có mục đích khác nhau và KHÔNG nên merge.
 * Không inject SettingRepository vào frontend controllers — dùng SettingService.
 */
class SettingRepository extends BaseRepository
{
    protected function getModel(): string
    {
        return Setting::class;
    }

    protected function getSearchFields(): array
    {
        return ['key', 'value'];
    }

    /**
     * Get setting by key
     */
    public function getByKey(string $key, $default = null)
    {
        return Setting::get($key, $default);
    }

    /**
     * Get multiple settings by keys
     */
    public function getByKeys(array $keys): array
    {
        $settings = $this->query()
            ->whereIn('key', $keys)
            ->pluck('value', 'key')
            ->toArray();

        // Fill missing keys with null
        foreach ($keys as $key) {
            if (!isset($settings[$key])) {
                $settings[$key] = null;
            }
        }

        return $settings;
    }

    /**
     * Set setting value
     */
    public function setSetting(string $key, $value, string $type = 'text'): bool
    {
        Setting::set($key, $value, $type);
        $this->clearCache($key);
        return true;
    }

    /**
     * Set multiple settings
     */
    public function setMultiple(array $settings): bool
    {
        foreach ($settings as $key => $value) {
            $type = is_array($value) ? 'json' : 'text';
            $actualValue = is_array($value) ? json_encode($value) : $value;
            Setting::set($key, $actualValue, $type);
            $this->clearCache($key);
        }
        return true;
    }

    /**
     * Filter by type
     */
    public function byType(string $type): self
    {
        return $this->setQuery($this->newQuery()->where('type', $type));
    }

    /**
     * Get text settings
     */
    public function textSettings(): self
    {
        return $this->byType('text');
    }

    /**
     * Get JSON settings
     */
    public function jsonSettings(): self
    {
        return $this->byType('json');
    }

    /**
     * Get boolean settings
     */
    public function booleanSettings(): self
    {
        return $this->byType('boolean');
    }

    /**
     * Get setting as integer
     */
    public function getAsInteger(string $key, int $default = 0): int
    {
        $value = $this->getByKey($key);
        return $value !== null ? (int) $value : $default;
    }

    /**
     * Get setting as boolean
     */
    public function getAsBoolean(string $key, bool $default = false): bool
    {
        $value = $this->getByKey($key);
        if ($value === null) {
            return $default;
        }
        return in_array($value, [true, 1, '1', 'true', 'yes'], true);
    }

    /**
     * Get setting as array (from JSON)
     */
    public function getAsArray(string $key, array $default = []): array
    {
        $value = $this->getByKey($key);
        if (!$value) {
            return $default;
        }
        if (is_array($value)) {
            return $value;
        }
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : $default;
    }

    /**
     * Get all settings as key-value pairs
     */
    public function getAllAsArray(): array
    {
        return $this->query()
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Get settings by key pattern (like "site_*")
     */
    public function getByPattern(string $pattern): Collection
    {
        return $this->query()
            ->where('key', 'like', $pattern)
            ->get();
    }

    /**
     * Get all site settings
     */
    public function getSiteSettings(): array
    {
        return $this->query()
            ->where('key', 'like', 'site_%')
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Get all email settings
     */
    public function getEmailSettings(): array
    {
        return $this->query()
            ->where('key', 'like', 'email_%')
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Get all payment settings
     */
    public function getPaymentSettings(): array
    {
        return $this->query()
            ->where('key', 'like', 'payment_%')
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Check if setting exists
     */
    public function hasKey(string $key): bool
    {
        return $this->query()->where('key', $key)->exists();
    }

    /**
     * Delete setting by key
     */
    public function deleteByKey(string $key): bool
    {
        $result = $this->query()->where('key', $key)->delete();
        $this->clearCache($key);
        return $result > 0;
    }

    /**
     * Clear cache for a specific key
     */
    public function clearCache(string $key = null): void
    {
        if ($key) {
            Cache::forget("setting_{$key}");
        } else {
            Setting::clearCache();
        }
    }

    /**
     * Get setting with default value and type casting
     */
    public function getValue(string $key, $default = null, string $type = 'text')
    {
        $setting = $this->query()->where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        return match ($type) {
            'integer' => (int) $setting->value,
            'boolean' => in_array($setting->value, [true, 1, '1', 'true'], true),
            'array' => json_decode($setting->value, true),
            'json' => json_decode($setting->value, true),
            default => $setting->value,
        };
    }
}
