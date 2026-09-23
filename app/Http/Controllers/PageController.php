<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Inquiry;
use App\Services\SettingService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    public function about()
    {
        $siteInfo  = $this->settingService->getSiteInfo();
        $introPage = Page::where('slug', 'gioi-thieu')->active()->first();

        // Use page's own header_image if set, otherwise fallback to default banner
        $pageBanner = $introPage && $introPage->header_image_url
            ? ['custom' => $introPage->header_image_url]
            : [];

        return view('pages.about', compact('siteInfo', 'introPage', 'pageBanner'));
    }

    public function contact()
    {
        $siteInfo = $this->settingService->getSiteInfo();
        $bannerKey = 'contact';
        return view('pages.contact', compact('siteInfo', 'bannerKey'));
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'zalo_id' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $inquiry = Inquiry::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'zalo_id' => $validated['zalo_id'] ?? null,
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        return redirect()->back()->with('success', 'Gửi liên hệ thành công! Chúng tôi sẽ phản hồi sớm nhất có thể.');
    }

    public function policy(string $slug)
    {
        $page = Page::where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Use page's own header_image if set, otherwise fallback to default banner
        $pageBanner = $page->header_image_url
            ? ['custom' => $page->header_image_url]
            : [];

        return view('pages.policy', compact('page', 'pageBanner'));
    }
}
