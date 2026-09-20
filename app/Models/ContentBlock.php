<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Model ContentBlock
 *
 * Lưu trữ các khối nội dung text có thể chỉnh sửa qua admin UI.
 * Hỗ trợ cache để tối ưu hiệu năng (3600s = 1 giờ).
 *
 * @property int    $id
 * @property string $key         Key duy nhất dùng để truy xuất trong code
 * @property string|null $value  Nội dung hiển thị
 * @property string $type        Loại field: text, textarea, richtext
 * @property string $group       Nhóm: home_hero, product_pages, auth, ...
 * @property string|null $label  Nhãn hiển thị trong admin
 * @property string|null $description Mô tả công dụng
 * @property int    $order       Thứ tự hiển thị
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class ContentBlock extends Model
{
    /**
     * Cache TTL mặc định: 1 giờ (3600 giây)
     */
    public const CACHE_TTL = 3600;

    /**
     * Tên bảng trong database
     */
    protected $table = 'content_blocks';

    /**
     * Các trường được phép mass assignment
     */
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'order',
    ];

    /**
     * Cast các kiểu dữ liệu
     */
    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Lấy nội dung theo key (có cache).
     *
     * Ưu tiên cache để tránh query DB nhiều lần trên các trang có nhiều content block.
     * Nếu cache lỗi (Redis down, file permission,...) sẽ fallback về query DB trực tiếp.
     *
     * @param  string $key     Key của content block
     * @param  mixed  $default Giá trị mặc định nếu không tìm thấy
     * @return mixed           Giá trị của block hoặc $default
     */
    public static function get(string $key, $default = null)
    {
        $cacheKey = static::cacheKey($key);

        try {
            return Cache::remember($cacheKey, static::CACHE_TTL, function () use ($key, $default) {
                $block = static::where('key', $key)->first();
                return $block ? $block->value : $default;
            });
        } catch (\Throwable $e) {
            // Log lỗi để debug nhưng không làm vỡ trang
            Log::warning("ContentBlock::get cache failed for key [{$key}]: " . $e->getMessage());

            try {
                $block = static::where('key', $key)->first();
                return $block ? $block->value : $default;
            } catch (\Throwable $e2) {
                Log::error("ContentBlock::get DB failed for key [{$key}]: " . $e2->getMessage());
                return $default;
            }
        }
    }

    /**
     * Cập nhật hoặc tạo mới một content block.
     *
     * Tự động xóa cache của key tương ứng để lần đọc sau thấy giá trị mới.
     *
     * @param  string $key        Key duy nhất
     * @param  string $value      Nội dung mới
     * @param  string $type       Loại field (text|textarea|richtext)
     * @param  string $group      Nhóm
     * @param  string|null $label Nhãn hiển thị
     * @return static            Instance vừa lưu
     */
    public static function set(
        string $key,
        ?string $value,
        string $type = 'text',
        string $group = 'general',
        ?string $label = null
    ): self {
        $block = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type'  => $type,
                'group' => $group,
                'label' => $label,
            ]
        );

        // Xóa cache để lần đọc tiếp theo lấy giá trị mới
        static::forgetCache($key);

        return $block;
    }

    /**
     * Xóa cache của một key cụ thể.
     *
     * @param string $key
     * @return void
     */
    public static function forgetCache(string $key): void
    {
        try {
            Cache::forget(static::cacheKey($key));
        } catch (\Throwable $e) {
            Log::warning("ContentBlock::forgetCache failed for key [{$key}]: " . $e->getMessage());
        }
    }

    /**
     * Xóa toàn bộ cache liên quan đến content blocks.
     *
     * Thường được gọi khi admin cập nhật nhiều blocks cùng lúc hoặc import dữ liệu mới.
     *
     * @return void
     */
    public static function clearCache(): void
    {
        try {
            // Xóa toàn bộ cache keys có prefix 'content_block_'
            // Cách an toàn: lặp qua các blocks đã có và forget từng key
            $keys = static::pluck('key')->all();

            foreach ($keys as $key) {
                Cache::forget(static::cacheKey($key));
            }
        } catch (\Throwable $e) {
            Log::warning('ContentBlock::clearCache failed: ' . $e->getMessage());

            // Fallback: flush toàn bộ cache
            try {
                Cache::flush();
            } catch (\Throwable $e2) {
                Log::error('Cache::flush failed: ' . $e2->getMessage());
            }
        }
    }

    /**
     * Lấy danh sách blocks theo group, sắp xếp theo order rồi key.
     *
     * Dùng cho admin UI để hiển thị blocks theo tab group.
     *
     * @param  string $group
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByGroup(string $group)
    {
        return static::where('group', $group)
            ->orderBy('order')
            ->orderBy('key')
            ->get();
    }

    /**
     * Lấy danh sách tất cả group duy nhất.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getGroups()
    {
        return static::query()
            ->select('group')
            ->distinct()
            ->orderBy('group')
            ->pluck('group');
    }

    /**
     * Tạo cache key theo chuẩn.
     *
     * @param  string $key
     * @return string
     */
    protected static function cacheKey(string $key): string
    {
        return "content_block_{$key}";
    }
}