<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ImageStorageService;
use App\Services\SeasonalPageService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeasonalPageController extends Controller
{
    public function __construct(
        protected ImageStorageService $images,
        protected SeasonalPageService $seasonal,
    ) {}

    public function index(): View
    {
        return view('admin.seasonal-pages.index', [
            'seasons' => $this->seasonal->listForAdmin(),
            'layoutLabels' => SeasonalPageService::LAYOUT_LABELS,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'slug' => 'nullable|string|max:150',
            'code' => 'nullable|string|max:10',
            'tagline' => 'nullable|string|max:255',
            'tagline_en' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:100',
            'status_en' => 'nullable|string|max:100',
            'date' => 'nullable|date',
            'intro' => 'nullable|string|max:2000',
            'intro_en' => 'nullable|string|max:2000',
            'name_en' => 'nullable|string|max:150',
            'cta_label' => 'nullable|string|max:150',
            'cta_label_en' => 'nullable|string|max:150',
            'cta_link' => 'nullable|string|max:500',
            'extra_label' => 'nullable|string|max:255',
            'extra_label_en' => 'nullable|string|max:255',
            'extra_link' => 'nullable|string|max:500',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'integer|exists:products,id',
        ]);

        $season = $this->seasonal->create($validated);

        if (! empty($validated['product_ids'])) {
            $this->seasonal->syncProducts($season['id'], $validated['product_ids']);
        }

        $message = 'Đã thêm trang lễ hội mới.';

        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => $message, 'redirect' => route('admin.seasonal-pages.edit', $season['id'])])
            : redirect()->route('admin.seasonal-pages.edit', $season['id'])->with('success', $message);
    }

    public function edit(string $seasonId): View
    {
        $meta = $this->seasonal->findForAdmin($seasonId);
        abort_unless($meta, 404);

        $data = $meta['custom']
            ? $this->seasonal->customSeason($seasonId)
            : $this->seasonal->builtIn($seasonId);

        // Get products for this season
        $seasonProducts = Product::with('productImages')
            ->forSeason($seasonId)
            ->orderBy('name')
            ->get();

        // All products for selection
        $allProducts = Product::with('productImages')
            ->active()
            ->orderBy('name')
            ->get();

        return view('admin.seasonal-pages.edit', [
            'seasonId' => $seasonId,
            'season' => $meta,
            'data' => $data ?? [],
            'heroImage' => $this->seasonal->heroUrl($seasonId),
            'gallery' => $this->seasonal->gallery($seasonId),
            'seasonProducts' => $seasonProducts,
            'allProducts' => $allProducts,
        ]);
    }

    public function update(Request $request, string $seasonId)
    {
        $meta = $this->seasonal->findForAdmin($seasonId);
        abort_unless($meta, 404);

        $rules = [
            'data' => 'required|array',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'nullable|exists:products,id',
            'hero_image' => 'nullable|string',
        ];

        if ($meta['custom']) {
            $rules['data.slug'] = 'nullable|string|max:150';
        }

        $validated = $request->validate($rules);

        $this->seasonal->updateSeason($seasonId, $validated['data']);
        $this->seasonal->syncProducts($seasonId, $validated['product_ids'] ?? []);

        if (! empty($validated['hero_image'])) {
            \App\Models\Setting::set($this->seasonal->heroKey($seasonId), $validated['hero_image'], 'image');
        }

        return response()->json(['success' => true, 'message' => 'Đã lưu thay đổi']);
    }

    public function destroy(string $seasonId)
    {
        abort_unless($this->seasonal->deleteCustom($seasonId), 403, 'Không thể xóa trang lễ hội gốc.');

        $message = 'Đã xóa trang lễ hội.';

        return request()->expectsJson()
            ? response()->json(['success' => true, 'message' => $message, 'redirect' => route('admin.seasonal-pages.index')])
            : redirect()->route('admin.seasonal-pages.index')->with('success', $message);
    }

    public function uploadHero(Request $request, string $seasonId)
    {
        abort_unless($this->seasonal->findForAdmin($seasonId), 404);

        $maxKb = (int) config('upload.limits.banner.max_size', 4096);
        $request->validate([
            'file' => "required|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
        ]);

        $oldPath = \App\Models\Setting::get($this->seasonal->heroKey($seasonId));

        $path = $this->images->upload(
            $request->file('file'),
            'images/seasonal',
            $oldPath,
            'seasonal_hero_'.$seasonId
        );

        \App\Models\Setting::set($this->seasonal->heroKey($seasonId), $path, 'image');

        return response()->json([
            'success' => true,
            'message' => 'Đã tải lên ảnh hero',
            'imageUrl' => $this->images->url($path),
        ]);
    }

    public function destroyHero(string $seasonId)
    {
        abort_unless($this->seasonal->findForAdmin($seasonId), 404);

        $oldPath = \App\Models\Setting::get($this->seasonal->heroKey($seasonId));
        if ($oldPath) {
            $this->images->delete($oldPath);
            \App\Models\Setting::where('key', $this->seasonal->heroKey($seasonId))->delete();
        }

        return response()->json(['success' => true, 'message' => 'Đã xóa ảnh hero']);
    }

    /**
     * Extra images shown in the season gallery section (admin-managed).
     */
    public function uploadGallery(Request $request, string $seasonId)
    {
        abort_unless($this->seasonal->findForAdmin($seasonId), 404);

        $maxKb = (int) config('upload.limits.banner.max_size', 4096);
        $request->validate([
            'file' => "required|file|mimes:jpg,jpeg,png,gif,webp|max:{$maxKb}",
        ]);

        $url = $this->seasonal->addGalleryImage($seasonId, $request->file('file'));

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm ảnh',
            'imageUrl' => $url,
            'images' => $this->seasonal->gallery($seasonId),
        ]);
    }

    public function destroyGallery(string $seasonId, int $index)
    {
        abort_unless($this->seasonal->findForAdmin($seasonId), 404);

        $this->seasonal->removeGalleryImage($seasonId, $index);

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa ảnh',
            'images' => $this->seasonal->gallery($seasonId),
        ]);
    }
}
