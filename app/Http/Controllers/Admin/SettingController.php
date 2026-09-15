<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\BannerService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settingsData = Setting::all()->pluck('value', 'key');
        $settings = $settingsData->toArray();
        $banners = (new BannerService)->all();

        // Add masked SMTP password for display
        $settings['smtp_password_masked'] = !empty($settings['smtp_password']) ? '••••••••' : '';

        return view('admin.settings.index', compact('settings', 'banners'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'site_logo' => 'nullable|image|max:2048',
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
        ]);

        // Handle site logo upload
        if ($request->hasFile('site_logo')) {
            $oldLogo = Setting::where('key', 'site_logo')->first();
            if ($oldLogo && $oldLogo->value) {
                Storage::disk('public')->delete($oldLogo->value);
            }
            $validated['site_logo'] = $request->file('site_logo')->store('settings', 'public');
        }

        // Handle checkbox booleans - convert to proper boolean values
        $checkboxFields = [
            'email_notification_enabled',
            'zalo_notification_enabled',
        ];
        foreach ($checkboxFields as $field) {
            $validated[$field] = $request->has($field) ? 1 : 0;
        }

        // Handle SMTP password separately - only update if provided
        if (isset($validated['smtp_password']) && !empty($validated['smtp_password'])) {
            Setting::updateOrCreate(
                ['key' => 'smtp_password'],
                ['value' => $validated['smtp_password'], 'type' => 'text']
            );
        }
        unset($validated['smtp_password']);

        // Save general settings
        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => 'text']
            );
        }

        // Handle banner image uploads
        $bannerKeys = array_keys(BannerService::BANNER_KEYS);
        foreach ($bannerKeys as $bannerKey) {
            $fieldName = 'banner_' . $bannerKey;
            if ($request->hasFile($fieldName)) {
                // Delete old banner file
                $oldBanner = Setting::where('key', $fieldName)->first();
                if ($oldBanner && $oldBanner->value) {
                    $oldPath = public_path($oldBanner->value);
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }
                // Save new banner to public/images/banners/
                $file = $request->file($fieldName);
                $filename = $bannerKey . '-hero.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/banners'), $filename);
                $path = 'images/banners/' . $filename;

                Setting::updateOrCreate(
                    ['key' => $fieldName],
                    ['value' => $path, 'type' => 'image']
                );
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Cập nhật cài đặt thành công');
    }
}
