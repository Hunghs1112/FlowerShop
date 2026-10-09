<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Product;
use App\Models\Inquiry;
use App\Models\FlowerOrigin;
use App\Models\Category;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        $passportCategories = $flowerCategories->map(fn ($category) => $category
            ? route('products.index', ['category' => $category->slug])
            : route('products.index'));
        return view('pages.about', compact('siteInfo', 'introPage', 'pageBanner', 'flowerMapData', 'flowers', 'categories', 'flowerCategories', 'passportCategories'));
    }

    public function guide()
    {
        $siteInfo = $this->settingService->getSiteInfo();
        $page = Page::whereIn('slug', Page::GUIDE_SLUGS)->active()
            ->orderByRaw("CASE slug WHEN 'huong-dan-dat-hang' THEN 0 ELSE 1 END")
            ->first();
        $pageBanner = [];
        return view('pages.guide', compact('siteInfo', 'pageBanner', 'page'));
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

    public function seasonHub()
    {
        return view('pages.seasonal.hub', [
            'seasonConfig' => $this->seasonalConfig('mua-le-hoi'),
        ]);
    }

    public function seasonAutumn()
    {
        return $this->seasonalPage('thu', 'pages.seasonal.autumn');
    }

    public function seasonHalloween()
    {
        return $this->seasonalPage('halloween', 'pages.seasonal.halloween');
    }

    public function seasonDanishTree(Request $request)
    {
        $sourceSlug = $request->routeIs('season.phu-kien') ? 'phu-kien-cay-thong' : 'mua-le-hoi';

        return $this->seasonalPage('thong', 'pages.seasonal.danish-tree', $sourceSlug);
    }

    private function seasonalPage(string $seasonId, string $view, string $sourceSlug = 'mua-le-hoi')
    {
        $config = $this->seasonalConfig($sourceSlug);
        $season = collect($config['seasons'])->firstWhere('id', $seasonId);
        abort_unless($season, 404);

        // Get products for this season from database
        $seasonProducts = Product::with(['productImages', 'category'])
            ->active()
            ->forSeason($seasonId)
            ->orderBy('name')
            ->get();

        // Build products array matching the JSON structure
        $dbProducts = $seasonProducts->map(fn($p) => [
            'name' => $p->name,
            'origin' => $p->origin ?? '',
            'code' => strtoupper(substr($p->category->slug ?? $p->slug, 0, 3)),
            'img' => $p->getPrimaryImageUrl(),
            'link' => route('products.show', $p->slug),
            'badge' => $p->is_new_arrival ? 'MỚI VỀ' : ($p->is_bestseller ? 'BÁN CHẠY' : ''),
        ])->values()->all();

        // Inject DB products into season config
        $season['products'] = $dbProducts;

        // Get hero image from settings
        $heroSetting = \App\Models\Setting::where('key', 'seasonal_' . $seasonId . '_hero')->value('value');
        if ($heroSetting) {
            $season['img'] = asset('storage/' . $heroSetting);
        }

        return view($view, [
            'seasonConfig' => [...$config, 'seasons' => [$season]],
        ]);
    }

    private function seasonalConfig(string $slug): array
    {
        $page = Page::where('slug', $slug)->active()->firstOrFail();
        $stored = json_decode($page->content, true, flags: JSON_THROW_ON_ERROR);
        $defaults = $this->seasonalFile('hub');
        $defaults['seasons'] = [
            $this->seasonalFile('autumn'),
            $this->seasonalFile('halloween'),
            $this->seasonalFile('danish-tree'),
        ];

        $storedSeasons = $stored['seasons'] ?? [];
        unset($stored['seasons']);
        $config = $this->mergeSeasonalData($defaults, $stored);
        $config['seasons'] = collect($defaults['seasons'])->map(function ($season) use ($storedSeasons) {
            $override = collect($storedSeasons)->firstWhere('id', $season['id']);
            $season = $override ? $this->mergeSeasonalData($season, $override) : $season;

            if (isset($season['tree'])) {
                $tree = &$season['tree'];
                $tree['addons'] = collect($tree['addons'] ?? [])->map(
                    fn ($item) => is_array($item) ? $item : ['name' => $item, 'price' => '']
                )->all();
                if (isset($tree['accessories'][0]) && is_string($tree['accessories'][0])) {
                    $tree['accessories'] = [[
                        'group' => 'Phụ kiện & đồ trang trí',
                        'items' => collect($tree['accessories'])->map(
                            fn ($item) => ['name' => $item, 'desc' => '', 'icon' => 'hop', 'price' => '', 'img' => '']
                        )->all(),
                    ]];
                }
                $tree['faq'] = collect($tree['faq'] ?? [])->map(fn ($item) => [
                    'q' => $item['q'] ?? $item['question'] ?? '',
                    'a' => $item['a'] ?? $item['answer'] ?? '',
                ])->all();
            }

            $season['url'] = match ($season['id']) {
                'thu' => route('season.autumn'),
                'halloween' => route('season.halloween'),
                'thong' => route('season.danish-tree'),
                default => '#',
            };

            return $season;
        })->all();
        $config['hub']['url'] = route('season.mua-le-hoi');
        $config['orderEndpoint'] = route('season.preorder');
        $config['csrfToken'] = csrf_token();
        $config['seasonSlug'] = $slug;

        return $config;
    }

    private function seasonalFile(string $file): array
    {
        return json_decode(file_get_contents(resource_path("data/seasonal/{$file}.json")), true, flags: JSON_THROW_ON_ERROR);
    }

    private function mergeSeasonalData(array $defaults, array $stored): array
    {
        foreach ($stored as $key => $value) {
            $defaults[$key] = is_array($value)
                && !array_is_list($value)
                && isset($defaults[$key])
                && is_array($defaults[$key])
                && !array_is_list($defaults[$key])
                    ? $this->mergeSeasonalData($defaults[$key], $value)
                    : $value;
        }

        return $defaults;
    }

    public function seasonPreorder(Request $request)
    {
        $seasonSlug = $request->validate(['season_slug' => ['required', Rule::in(Page::SEASONAL_SLUGS)]])['season_slug'];
        $seasonConfig = $this->seasonalConfig($seasonSlug);
        $treeSeason = collect($seasonConfig['seasons'] ?? [])->first(fn ($season) => isset($season['tree']));
        $tree = $treeSeason['tree'] ?? [];
        $accessoryNames = collect($tree['accessories'] ?? [])->flatMap(fn ($group) =>
            collect($group['items'] ?? [])->pluck('name')
        )->merge(collect($tree['packages']['items'] ?? [])->pluck('name')->map(fn ($name) => "Bộ {$name}"))->all();
        $addonNames = collect($tree['addons'] ?? [])->pluck('name')->all();

        $validated = $request->validate([
            'size' => ['required', Rule::in(collect($tree['sizes'] ?? [])->pluck('label')->all())],
            'accessories' => 'nullable|array|max:20',
            'accessories.*' => ['string', Rule::in($accessoryNames)],
            'accessory_quantities' => 'nullable|array|max:20',
            'accessory_quantities.*.name' => ['required', 'string', Rule::in($accessoryNames)],
            'accessory_quantities.*.quantity' => 'required|integer|min:1|max:99',
            'addons' => 'nullable|array|max:10',
            'addons.*' => ['string', Rule::in($addonNames)],
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+().\s-]{9,20}$/'],
            'address' => 'required|string|max:500',
            'delivery_date' => 'nullable|date|after_or_equal:today',
            'notes' => 'nullable|string|max:1000',
        ]);
        $validated['season_slug'] = $seasonSlug;
        $accessorySummary = collect($validated['accessory_quantities'] ?? [])->map(
            fn ($item) => $item['name'] . ($item['quantity'] > 1 ? ' x' . $item['quantity'] : '')
        )->implode(', ') ?: implode(', ', $validated['accessories'] ?? []);

        $message = implode("\n", array_filter([
            'ĐẶT TRƯỚC MÙA LỄ HỘI',
            'Trang: ' . $validated['season_slug'],
            'Cỡ cây: ' . $validated['size'],
            'Phụ kiện: ' . ($accessorySummary ?: '-'),
            'Dịch vụ: ' . (implode(', ', $validated['addons'] ?? []) ?: '-'),
            'Địa chỉ: ' . $validated['address'],
            'Ngày nhận: ' . ($validated['delivery_date'] ?? '-'),
            'Ghi chú: ' . ($validated['notes'] ?? '-'),
        ]));

        Inquiry::create([
            'user_id' => auth()->id(),
            'type' => 'tree_preorder',
            'source_slug' => $validated['season_slug'],
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'message' => $message,
            'order_data' => [
                'size' => $validated['size'],
                'accessories' => $validated['accessories'] ?? [],
                'accessory_quantities' => $validated['accessory_quantities'] ?? [],
                'addons' => $validated['addons'] ?? [],
                'address' => $validated['address'],
                'delivery_date' => $validated['delivery_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ],
            'status' => 'new',
        ]);

        return response()->json([
            'message' => 'Lâm Nhiên Thảo đã nhận yêu cầu và sẽ liên hệ để xác nhận cây, lịch giao và mức cọc.',
        ], 201);
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
        return redirect()->route('mystery-box.index');
    }

}
