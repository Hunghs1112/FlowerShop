<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Repositories\SettingRepository;
use App\Services\BannerService;
use App\Services\ImageStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    protected SettingRepository $settings;
    protected ImageStorageService $images;

    public function __construct(
        SettingRepository $settings,
        ImageStorageService $images
    ) {
        $this->settings = $settings;
        $this->images = $images;
        
    }

    // ============================================================
    // AJAX: Update single setting field
    // ============================================================
    public function updateField(Request $request)
    {

        $field = $request->input('field');
        $value = $request->input('value');

        // Validate field name
        $allowedFields = [
            'site_name', 'site_tagline', 'site_description', 'email', 'phone', 'address',
            'zalo_id', 'zalo_url', 'facebook_url', 'instagram_url', 'tiktok_url',
            'social_youtube', 'about', 'meta_title', 'meta_description', 'meta_keywords',
            'business_hours', 'email_notification_enabled', 'zalo_notification_enabled',
            'smtp_host', 'smtp_port', 'smtp_username', 'smtp_encryption',
            'order_notification_email', 'contact_form_email', 'zalo_oa_id', 'zalo_access_token',
            'google_analytics'
        ];
        foreach (array_keys(BannerService::BANNER_KEYS) as $bannerKey) {
            $allowedFields[] = 'banner_' . $bannerKey . '_hide_overlay';
            $allowedFields[] = 'banner_' . $bannerKey . '_height_desktop';
            $allowedFields[] = 'banner_' . $bannerKey . '_height_mobile';
        }

        if (!in_array($field, $allowedFields)) {
            return response()->json([
                'success' => false,
                'message' => 'Trường không hợp lệ'
            ], 422);
        }

        // Handle checkbox fields (boolean)
        $booleanFields = [
            'email_notification_enabled',
            'zalo_notification_enabled',
            ...array_map(
                fn (string $key) => 'banner_' . $key . '_hide_overlay',
                array_keys(BannerService::BANNER_KEYS)
            ),
        ];
        if (in_array($field, $booleanFields)) {
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        }

        // Handle email validation
        if (str_contains($field, 'email') || $field === 'email') {
            if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email không hợp lệ'
                ], 422);
            }
        }

        // Handle URL validation
        if (str_contains($field, 'url')) {
            if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
                return response()->json([
                    'success' => false,
                    'message' => 'URL không hợp lệ'
                ], 422);
            }
        }

        // Handle port validation
        if ($field === 'smtp_port') {
            if (!empty($value) && (!is_numeric($value) || $value < 1 || $value > 65535)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Port không hợp lệ (1-65535)'
                ], 422);
            }
        }

        if (str_ends_with($field, '_height_desktop') || str_ends_with($field, '_height_mobile')) {
            if (!is_numeric($value) || $value < 160 || $value > 1200) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chiều cao banner phải từ 160 đến 1200px'
                ], 422);
            }
            $value = (int) $value;
        }

        // Save using SettingRepository
        $this->settings->setSetting($field, $value, 'text');

        return response()->json([
            'success' => true,
            'message' => 'Đã lưu ' . $field,
            'data' => [
                $field => $value
            ]
        ]);
    }

    public function index()
    {

        $settingsData = $this->settings->getAllAsArray();
        $bannerService = new BannerService;
        $banners = $bannerService->all();
        $bannerSizes = $bannerService->sizes();

        // Add masked SMTP password for display
        $settingsData['smtp_password_masked'] = !empty($settingsData['smtp_password'] ?? null) ? '••••••••' : '';

        return view('admin.settings.index', compact('settingsData', 'banners', 'bannerSizes'));
    }

    public function update(Request $request)
    {

        $logoMax  = (int) config('upload.limits.site_logo.max_size', 2048);
        $bannMax  = (int) config('upload.limits.banner.max_size', 4096);

        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'site_logo' => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$logoMax}",
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'zalo_id' => 'nullable|string|max:50',
            'zalo_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
            'about' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'google_analytics' => 'nullable|string|max:50',
            'business_hours' => 'nullable|string',

            // Notification settings
            'email_notification_enabled' => 'nullable|boolean',
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|integer|min:1|max:65535',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'smtp_encryption' => 'nullable|string|in:tls,ssl',
            'order_notification_email' => 'nullable|email|max:255',
            'contact_form_email' => 'nullable|email|max:255',
            'zalo_notification_enabled' => 'nullable|boolean',
            'zalo_oa_id' => 'nullable|string|max:100',
            'zalo_access_token' => 'nullable|string|max:500',
            'zalo_admin_phone' => 'nullable|string|max:20',

            // Banner uploads
            'banner_home'       => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$bannMax}",
            'banner_products'   => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$bannMax}",
            'banner_categories' => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$bannMax}",
            'banner_blog'       => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$bannMax}",
            'banner_about'      => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$bannMax}",
            'banner_contact'    => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$bannMax}",
            'banner_b2c'        => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$bannMax}",
            'banner_cart'       => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$bannMax}",
            'banner_checkout'   => "nullable|file|mimes:jpg,jpeg,png,gif,webp|max:{$bannMax}",
        ]);

        // Handle site logo upload
        $logoOldPath = $this->settings->getByKey('site_logo');
        if ($request->hasFile('site_logo')) {
            $logoOldPath = $logoOldPath ?: null;
        }

        // Handle checkbox booleans
        $checkboxFields = [
            'email_notification_enabled',
            'zalo_notification_enabled',
        ];
        foreach ($checkboxFields as $field) {
            $validated[$field] = $request->has($field) ? 1 : 0;
        }

        try {
            DB::transaction(function () use ($request, &$validated, $logoOldPath) {
                // ---- Logo ----
                if ($request->hasFile('site_logo')) {
                    $validated['site_logo'] = $this->images->upload(
                        $request->file('site_logo'),
                        config('upload.disks.folders.logo', 'settings'),
                        $logoOldPath
                    );
                }

                // ---- SMTP password (write only if non-empty) ----
                if (!empty($validated['smtp_password'])) {
                    $this->settings->setSetting('smtp_password', $validated['smtp_password'], 'text');
                }
                unset($validated['smtp_password']);

                // ---- Banners ----
                $bannerKeys = array_keys(BannerService::BANNER_KEYS);
                foreach ($bannerKeys as $bannerKey) {
                    $fieldName = 'banner_' . $bannerKey;
                    if (!$request->hasFile($fieldName)) {
                        continue;
                    }

                    $oldBannerPath = $this->settings->getByKey($fieldName);

                    $newPath = $this->images->upload(
                        $request->file($fieldName),
                        'images/banners',
                        $oldBannerPath,
                        $bannerKey
                    );

                    $this->settings->setSetting($fieldName, $newPath, 'image');
                }

                // ---- Everything else ----
                foreach ($validated as $key => $value) {
                    $this->settings->setSetting($key, $value, 'text');
                }
            });
        } catch (\Throwable $e) {
            if ($request->hasFile('site_logo') && !empty($validated['site_logo']) && $validated['site_logo'] !== $logoOldPath) {
                $this->images->delete($validated['site_logo']);
            }
            throw $e;
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Cập nhật cài đặt thành công');
    }

    // ============================================================
    // AJAX: Upload logo
    // ============================================================
    public function uploadLogo(Request $request)
    {

        $maxKb = (int) config('upload.limits.site_logo.max_size', 2048);

        $request->validate([
            'file' => "required|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}"
        ]);

        $logoOldPath = $this->settings->getByKey('site_logo');

        try {
            $path = $this->images->upload(
                $request->file('file'),
                config('upload.disks.folders.logo', 'settings'),
                $logoOldPath
            );

            $this->settings->setSetting('site_logo', $path, 'image');

            return response()->json([
                'success' => true,
                'message' => 'Đã tải lên logo',
                // Banner files live in public/images/banners, not storage/app/public.
                'imageUrl' => $this->images->url($path),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tải lên: ' . $e->getMessage()
            ], 500);
        }
    }

    // ============================================================
    // AJAX: Upload banner
    // ============================================================
    public function uploadBanner(Request $request, string $key)
    {

        $allowedKeys = array_keys(BannerService::BANNER_KEYS);
        if (!in_array($key, $allowedKeys, true)) {
            abort(404);
        }

        $maxKb = (int) config('upload.limits.banner.max_size', 4096);

        $request->validate([
            'file' => "required|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}"
        ]);

        $fieldName = 'banner_' . $key;
        $oldBannerPath = $this->settings->getByKey($fieldName);

        try {
            $path = $this->images->upload(
                $request->file('file'),
                'images/banners',
                $oldBannerPath,
                $key
            );

            $this->settings->setSetting($fieldName, $path, 'image');

            return response()->json([
                'success' => true,
                'message' => 'Đã tải lên banner',
                'imageUrl' => $this->images->url($path),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tải lên: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * DELETE /admin/settings/logo
     * Remove the site logo file + DB row.
     */
    public function deleteLogo()
    {

        $logoPath = $this->settings->getByKey('site_logo');
        if ($logoPath) {
            $this->images->delete($logoPath);
            $this->settings->deleteByKey('site_logo');
        }

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Đã xóa logo.']);
        }
        return redirect()->route('admin.settings.index')
            ->with('success', 'Đã xóa logo.');
    }

    /**
     * DELETE /admin/settings/banner/{key}
     * Remove a single banner image and clear its DB setting.
     */
    public function deleteBanner(string $key)
    {

        $allowedKeys = array_keys(BannerService::BANNER_KEYS);
        if (!in_array($key, $allowedKeys, true)) {
            abort(404);
        }

        $fieldName = 'banner_' . $key;
        $bannerPath = $this->settings->getByKey($fieldName);
        if ($bannerPath) {
            $this->images->delete($bannerPath);
            $this->settings->deleteByKey($fieldName);
        }

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Đã xóa ảnh header.']);
        }
        return redirect()->route('admin.settings.index')
            ->with('success', 'Đã xóa ảnh header.');
    }
}
