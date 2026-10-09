<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use App\Services\BannerService;
use App\Services\ImageStorageService;
use Illuminate\Http\Request;

class PageBannerController extends Controller
{
    public function __construct(
        protected SettingRepository $settings,
        protected ImageStorageService $images,
    ) {}

    public function index()
    {
        $bannerService = new BannerService;
        $banners       = $bannerService->all();
        $bannerSizes   = $bannerService->sizes();

        // Load hide_overlay flags
        $hideOverlay = [];
        foreach (array_keys(BannerService::BANNER_KEYS) as $key) {
            $hideOverlay[$key] = (bool) $this->settings->getByKey('banner_' . $key . '_hide_overlay');
        }

        return view('admin.page-banners.index', compact('banners', 'bannerSizes', 'hideOverlay'));
    }

    // ----------------------------------------------------------------
    // AJAX: Upload ảnh header cho 1 trang
    // ----------------------------------------------------------------
    public function upload(Request $request, string $key)
    {
        if (!array_key_exists($key, BannerService::BANNER_KEYS)) {
            abort(404);
        }

        $maxKb = (int) config('upload.limits.banner.max_size', 4096);
        $request->validate([
            'file' => "required|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
        ]);

        $fieldName = 'banner_' . $key;
        $oldPath   = $this->settings->getByKey($fieldName);

        $path = $this->images->upload(
            $request->file('file'),
            'images/banners',
            $oldPath,
            $key
        );

        $this->settings->setSetting($fieldName, $path, 'image');

        return response()->json([
            'success'  => true,
            'message'  => 'Đã tải lên ảnh header',
            'imageUrl' => $this->images->url($path),
        ]);
    }

    // ----------------------------------------------------------------
    // AJAX: Xóa ảnh header của 1 trang
    // ----------------------------------------------------------------
    public function destroy(string $key)
    {
        if (!array_key_exists($key, BannerService::BANNER_KEYS)) {
            abort(404);
        }

        $fieldName = 'banner_' . $key;
        $oldPath   = $this->settings->getByKey($fieldName);

        if ($oldPath) {
            $this->images->delete($oldPath);
            $this->settings->deleteByKey($fieldName);
        }

        return response()->json(['success' => true, 'message' => 'Đã xóa ảnh header.']);
    }

    // ----------------------------------------------------------------
    // AJAX: Cập nhật field (height, hide_overlay)
    // ----------------------------------------------------------------
    public function updateField(Request $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');

        // Xây danh sách allowed fields động từ BANNER_KEYS
        $allowed = [];
        foreach (array_keys(BannerService::BANNER_KEYS) as $bannerKey) {
            $allowed[] = 'banner_' . $bannerKey . '_hide_overlay';
            $allowed[] = 'banner_' . $bannerKey . '_height_desktop';
            $allowed[] = 'banner_' . $bannerKey . '_height_mobile';
        }

        if (!in_array($field, $allowed, true)) {
            return response()->json(['success' => false, 'message' => 'Trường không hợp lệ'], 422);
        }

        // Validate theo loại field
        if (str_ends_with($field, '_hide_overlay')) {
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        } elseif (str_ends_with($field, '_height_desktop') || str_ends_with($field, '_height_mobile')) {
            if (!is_numeric($value) || $value < 160 || $value > 1200) {
                return response()->json(['success' => false, 'message' => 'Chiều cao phải từ 160 đến 1200px'], 422);
            }
            $value = (int) $value;
        }

        $this->settings->setSetting($field, $value, 'text');

        return response()->json(['success' => true, 'message' => 'Đã lưu', 'data' => [$field => $value]]);
    }
}
