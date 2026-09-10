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
        return view('pages.about', compact('siteInfo', 'introPage'));
    }

    public function contact()
    {
        $siteInfo = $this->settingService->getSiteInfo();
        return view('pages.contact', compact('siteInfo'));
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

        return redirect()->back()->with('success', __('messages.contact.send_success'));
    }

    public function policy(string $slug)
    {
        $page = Page::where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Use English title if locale is EN
        if (app()->getLocale() === 'en' && $page->title_en) {
            $page->title = $page->title_en;
        }
        if (app()->getLocale() === 'en' && $page->content_en) {
            $page->content = $page->content_en;
        }

        return view('pages.policy', compact('page'));
    }
}
