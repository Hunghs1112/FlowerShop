<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Product;
use App\Services\ImageStorageService;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeasonalPageController extends Controller
{
    public const SEASONS = [
        'thu' => [
            'label' => 'Hội Mùa Thu',
            'name' => 'autumn',
            'json' => 'autumn.json',
        ],
        'halloween' => [
            'label' => 'Halloween',
            'name' => 'halloween',
            'json' => 'halloween.json',
        ],
        'thong' => [
            'label' => 'Cây Thông Đan Mạch',
            'name' => 'danish-tree',
            'json' => 'danish-tree.json',
        ],
    ];

    public function __construct(
        protected ImageStorageService $images,
        protected SettingRepository $settings,
    ) {}

    public function index(): View
    {
        return view('admin.seasonal-pages.index', [
            'seasons' => self::SEASONS,
        ]);
    }

    public function edit(string $seasonId): View
    {
        abort_unless(isset(self::SEASONS[$seasonId]), 404);

        $season = self::SEASONS[$seasonId];
        $defaultData = $this->loadDefaultJson($season['json']);
        $page = Page::where('slug', 'mua-le-hoi')->active()->first();

        // Load stored content from page
        $storedContent = [];
        if ($page) {
            $stored = json_decode($page->content, true);
            $storedSeasons = $stored['seasons'] ?? [];
            $storedSeason = collect($storedSeasons)->firstWhere('id', $seasonId);
            if ($storedSeason) {
                $storedContent = $storedSeason;
            }
        }

        // Merge default + stored (stored overrides default)
        $data = $this->mergeSeasonData($defaultData, $storedContent);

        // Get products for this season
        $seasonProducts = Product::with('productImages')
            ->forSeason($seasonId)
            ->orderBy('name')
            ->get();

        // All products for selection modal
        $allProducts = Product::with('productImages')
            ->active()
            ->orderBy('name')
            ->get();

        // Hero image from settings
        $heroImage = $this->settings->getByKey('seasonal_' . $seasonId . '_hero');

        return view('admin.seasonal-pages.edit', [
            'seasonId' => $seasonId,
            'season' => $season,
            'data' => $data,
            'page' => $page,
            'heroImage' => $heroImage,
            'seasonProducts' => $seasonProducts,
            'allProducts' => $allProducts,
        ]);
    }

    public function update(Request $request, string $seasonId)
    {
        abort_unless(isset(self::SEASONS[$seasonId]), 404);

        $validated = $request->validate([
            'data' => 'required|array',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'nullable|exists:products,id',
            'hero_image' => 'nullable|string',
        ]);

        $page = Page::where('slug', 'mua-le-hoi')->first();
        abort_unless($page, 404);

        // Update product season assignments
        Product::where('season_id', $seasonId)->update(['season_id' => null]);
        if (!empty($validated['product_ids'])) {
            Product::whereIn('id', $validated['product_ids'])->update(['season_id' => $seasonId]);
        }

        // Merge data into page content
        $stored = json_decode($page->content, true) ?: [];
        $storedSeasons = $stored['seasons'] ?? [];
        $seasonIndex = collect($storedSeasons)->search(fn($s) => ($s['id'] ?? '') === $seasonId);

        // Update or insert season data
        $seasonData = $this->normalizeSeasonData($validated['data'], $seasonId);
        if ($seasonIndex !== false) {
            $storedSeasons[$seasonIndex] = array_merge($storedSeasons[$seasonIndex], $seasonData);
        } else {
            $storedSeasons[] = $seasonData;
        }
        $stored['seasons'] = $storedSeasons;

        $page->update(['content' => json_encode($stored, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)]);

        // Save hero image to settings
        if (!empty($validated['hero_image'])) {
            $this->settings->setSetting('seasonal_' . $seasonId . '_hero', $validated['hero_image'], 'image');
        }

        return response()->json(['success' => true, 'message' => 'Đã lưu thay đổi']);
    }

    public function uploadHero(Request $request, string $seasonId)
    {
        abort_unless(isset(self::SEASONS[$seasonId]), 404);

        $maxKb = (int) config('upload.limits.banner.max_size', 4096);
        $request->validate([
            'file' => "required|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
        ]);

        $oldPath = $this->settings->getByKey('seasonal_' . $seasonId . '_hero');

        $path = $this->images->upload(
            $request->file('file'),
            'images/seasonal',
            $oldPath,
            'seasonal_hero_' . $seasonId
        );

        $this->settings->setSetting('seasonal_' . $seasonId . '_hero', $path, 'image');

        return response()->json([
            'success' => true,
            'message' => 'Đã tải lên ảnh hero',
            'imageUrl' => $this->images->url($path),
        ]);
    }

    public function destroyHero(string $seasonId)
    {
        abort_unless(isset(self::SEASONS[$seasonId]), 404);

        $oldPath = $this->settings->getByKey('seasonal_' . $seasonId . '_hero');
        if ($oldPath) {
            $this->images->delete($oldPath);
            $this->settings->deleteByKey('seasonal_' . $seasonId . '_hero');
        }

        return response()->json(['success' => true, 'message' => 'Đã xóa ảnh hero']);
    }

    protected function loadDefaultJson(string $file): array
    {
        $path = resource_path("data/seasonal/{$file}");
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true);
        }
        return [];
    }

    protected function mergeSeasonData(array $defaults, array $stored): array
    {
        foreach ($stored as $key => $value) {
            if (is_array($value) && isset($defaults[$key]) && is_array($defaults[$key])) {
                $defaults[$key] = $this->mergeSeasonData($defaults[$key], $value);
            } else {
                $defaults[$key] = $value;
            }
        }
        return $defaults;
    }

    protected function normalizeSeasonData(array $data, string $seasonId): array
    {
        // Clean up data before saving
        $result = [];
        foreach ($data as $key => $value) {
            if (in_array($key, ['products'])) continue; // products handled separately
            if ($value === '' || $value === null) continue;
            $result[$key] = $value;
        }
        return $result;
    }
}
