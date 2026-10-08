<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Inquiry;
use App\Models\FlowerOrigin;
use App\Models\Category;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            ? ['custom' => $introPage->header_image_url, 'hide_overlay' => $introPage->hide_header_overlay]
            : [];

        $flowers = FlowerOrigin::active()->orderBy('sort_order')->get();
        $flowerMapData = $flowers->map(fn ($f) => [
            'id' => $f->country_code ?? Str::lower(Str::substr($f->slug, 0, 2)),
            'country' => $f->country,
            'flower' => $f->flower,
            'latin' => $f->latin,
            'region' => $f->region,
            'lon' => (float) $f->lon,
            'lat' => (float) $f->lat,
            'map_x' => (int) $f->map_x,
            'map_y' => (int) $f->map_y,
            'coord' => $f->coordinate,
            'img' => $f->image_url,
        ])->values();
        $categories = Category::active()->withCount('products')->orderBy('sort_order')->get();
        $countryNeedles = [
            'cn' => ['trung quoc', 'trung-quoc', 'kunming'], 'nl' => ['ha lan', 'ha-lan'],
            'ec' => ['ecuador'], 'za' => ['nam phi', 'nam-phi', 'namphi'], 'jp' => ['nhat ban', 'nhat-ban'],
            'my' => ['malaysia', 'peony mum'], 'vn' => ['viet nam', 'viet-nam'],
            'co' => ['colombia'], 'nz' => ['new zealand', 'new-zealand'],
        ];
        $flowerCategories = collect($countryNeedles)->mapWithKeys(function (array $needles, string $country) use ($categories) {
            $category = $categories->first(function (Category $item) use ($needles) {
                $haystack = Str::lower($item->name . ' ' . $item->slug);
                return collect($needles)->contains(fn (string $needle) => Str::contains($haystack, Str::lower($needle)));
            });
            return [$country => $category ?: $categories->firstWhere('slug', $country === 'vn' ? 'hoa-tuoi-moi' : 'hoa-nhap-khau')];
        });
        return view('pages.about', compact('siteInfo', 'introPage', 'pageBanner', 'flowerMapData', 'flowers', 'categories', 'flowerCategories'));
    }

    public function guide()
    {
        $siteInfo = $this->settingService->getSiteInfo();
        $pageBanner = [];
        return view('pages.guide', compact('siteInfo', 'pageBanner'));
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

        return redirect()->back()->with('success', 'Gửi liên hệ thành công! Chúng tôi sẽ phản hồi sớm nhất có thể.');
    }

    public function policy(string $slug)
    {
        $page = Page::where('slug', $slug)
            ->active()
            ->first();

        if (!$page && $slug === 'chinh-sach-cua-chung-toi') {
            $page = Page::where('slug', 'chinh-sach-doi-tra')->active()->first();
        }

        if (!$page && $slug === 'chinh-sach-doi-tra') {
            $page = Page::where('slug', 'chinh-sach-cua-chung-toi')->active()->first();
        }

        abort_if(!$page, 404);

        // Use page's own header_image if set, otherwise fallback to default banner
        $pageBanner = $page->header_image_url
            ? ['custom' => $page->header_image_url, 'hide_overlay' => $page->hide_header_overlay]
            : [];

        return view('pages.policy', compact('page', 'pageBanner'));
    }

    public function seasonHub(string $slug)
    {
        $siteInfo = $this->settingService->getSiteInfo();

        $validSlugs = ['phu-kien-cay-thong', 'mua-le-hoi'];
        abort_if(!in_array($slug, $validSlugs), 404);

        return view("pages.season-{$slug}", compact('siteInfo'));
    }


    public function policyBaoMat()
    {
        $siteInfo = $this->settingService->getSiteInfo();
        $page = Page::where('slug', 'chinh-sach-bao-mat')->active()->first();
        return view('pages.policy', compact('siteInfo', 'page'));
    }

    public function policyOurs()
    {
        $siteInfo = $this->settingService->getSiteInfo();
        $page = Page::where('slug', 'chinh-sach-cua-chung-toi')->active()->first();
        return view('pages.policy-ours', compact('siteInfo', 'page'));
    }

    public function policyDelivery()
    {
        $siteInfo = $this->settingService->getSiteInfo();
        $page = Page::where('slug', 'chinh-sach-giao-hang')->active()->first();
        return view('pages.policy-delivery', compact('siteInfo', 'page'));
    }

    public function policyDieuKhoan()
    {
        $siteInfo = $this->settingService->getSiteInfo();
        $page = Page::where('slug', 'dieu-khoan-dich-vu')->active()->first();
        return view('pages.policy-terms', compact('siteInfo', 'page'));
    }

    public function canPhong()
    {
        $siteInfo = $this->settingService->getSiteInfo();
        return view('can-phong-bi-mat', compact('siteInfo'));
    }

}
