<?php

namespace App\Http\Controllers;

use App\Mail\B2cNotificationMail;
use App\Models\B2cInquiry;
use App\Services\NotificationService;
use App\Services\SettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class B2cController extends Controller
{
    public function __construct(
        protected NotificationService $notificationService,
        protected SettingService $settingService,
    ) {
    }

    /** Business type constants that we accept on the form. */
    private const BUSINESS_TYPES = [
        'traditional_shop',
        'event_decor',
        'florist',
        'online_shop',
    ];

    /**
     * Display the B2C landing/registration page.
     */
    public function index(): View
    {
        $siteInfo = $this->settingService->getSiteInfo();
        $bannerKey = 'b2c';

        return view('pages.b2c', [
            'siteInfo'   => $siteInfo,
            'bannerKey'  => $bannerKey,
            'businessTypes' => B2cInquiry::BUSINESS_TYPES,
        ]);
    }

    /**
     * Persist a B2C inquiry and notify the admin.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'business_type'    => ['required', 'string', 'in:' . implode(',', self::BUSINESS_TYPES)],
            'contact_name'     => ['required', 'string', 'max:255'],
            'contact_email'    => ['nullable', 'email', 'max:255'],

            'business_name'    => ['required', 'string', 'max:255'],
            'address'          => ['required', 'string', 'max:500'],
            'phone'            => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s().]+$/'],
            'years_in_business'=> ['required', 'integer', 'min:0', 'max:200'],
            'social_media'     => ['required', 'url', 'max:500'],
            'tax_code'         => ['required', 'string', 'max:50'],
            'vat_email'        => ['required', 'email', 'max:255'],
            'business_license' => ['required', 'string', 'max:100'],
        ], [
            'business_type.required'    => 'Vui lòng chọn loại hình kinh doanh.',
            'business_type.in'          => 'Loại hình kinh doanh không hợp lệ.',
            'contact_name.required'     => 'Vui lòng nhập họ và tên.',
            'contact_name.max'          => 'Họ và tên không quá 255 ký tự.',
            'contact_email.email'       => 'Email liên hệ không đúng định dạng.',
            'business_name.required'    => 'Vui lòng nhập tên cửa hàng / đơn vị.',
            'address.required'          => 'Vui lòng nhập địa chỉ.',
            'phone.required'            => 'Vui lòng nhập số điện thoại.',
            'phone.regex'               => 'Số điện thoại không hợp lệ.',
            'years_in_business.required'=> 'Vui lòng nhập số năm hoạt động.',
            'years_in_business.integer'  => 'Số năm hoạt động phải là số.',
            'years_in_business.min'      => 'Số năm hoạt động không được âm.',
            'social_media.required'     => 'Vui lòng nhập trang mạng xã hội.',
            'social_media.url'          => 'Đường dẫn mạng xã hội không hợp lệ.',
            'tax_code.required'         => 'Vui lòng nhập mã số thuế.',
            'vat_email.required'        => 'Vui lòng nhập email nhận hóa đơn VAT.',
            'vat_email.email'           => 'Email nhận hóa đơn VAT không đúng định dạng.',
            'business_license.required' => 'Vui lòng nhập số giấy phép kinh doanh.',
        ]);

        $inquiry = B2cInquiry::create([
            'business_type'     => $validated['business_type'],
            'contact_name'      => strip_tags($validated['contact_name']),
            'contact_email'     => isset($validated['contact_email'])
                ? filter_var($validated['contact_email'], FILTER_SANITIZE_EMAIL)
                : null,
            'business_name'     => strip_tags($validated['business_name']),
            'address'           => strip_tags($validated['address']),
            'phone'             => strip_tags($validated['phone']),
            'years_in_business' => (int) $validated['years_in_business'],
            'social_media'      => strip_tags($validated['social_media']),
            'tax_code'          => strip_tags($validated['tax_code']),
            'vat_email'         => filter_var($validated['vat_email'], FILTER_SANITIZE_EMAIL),
            'business_license'  => strip_tags($validated['business_license']),
            'status'            => 'new',
        ]);

        $this->sendNotification($inquiry);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Đăng ký B2C thành công!',
                'data'    => [
                    'id' => $inquiry->id,
                ],
            ]);
        }

        return redirect()
            ->route('b2c')
            ->with('b2c_success', 'Đăng ký B2C thành công! Chúng tôi sẽ liên hệ bạn trong thời gian sớm nhất.');
    }

    /**
     * Send notification email to admin (graceful degradation).
     */
    protected function sendNotification(B2cInquiry $inquiry): void
    {
        $recipient = env('B2C_NOTIFICATION_EMAIL') ?: env('MAIL_ADMIN_EMAIL');

        if (empty($recipient)) {
            Log::warning('B2C notification skipped: no recipient configured', [
                'inquiry_id' => $inquiry->id,
            ]);
            return;
        }

        try {
            // Apply DB-stored SMTP settings if email notifications are enabled.
            if ($this->notificationService->isEmailEnabled()) {
                $this->notificationService->applyMailConfig();
            }

            Mail::to($recipient)->send(new B2cNotificationMail($inquiry));

            Log::info('B2C notification email sent', [
                'inquiry_id' => $inquiry->id,
                'recipient'  => $recipient,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send B2C notification email', [
                'inquiry_id' => $inquiry->id,
                'recipient'  => $recipient,
                'error'      => $e->getMessage(),
            ]);
        }
    }
}
