<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesAjaxFieldUpdates;
use App\Http\Controllers\Traits\HandlesImageUpload;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Http\Responses\AjaxResponse;
use App\Models\Banner;
use App\Services\ImageStorageService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BannerController extends Controller
{
    use HandlesAjaxFieldUpdates;
    use HandlesImageUpload;

    protected ImageStorageService $images;
    public function __construct(ImageStorageService $images)
    {
        $this->images = $images;
        }

    /**
     * Display a listing of banners
     */
    public function index(): View
    {
        $banners = Banner::orderBy('sort_order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new banner
     */
    public function create(): View
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created banner
     */
    public function store(StoreBannerRequest $request)
    {
        try {
            $imagePath = $this->images->upload(
                $request->file('image'),
                'images/banners'
            );

            Banner::create(array_merge(
                $request->validated(),
                [
                    'image_path' => $imagePath,
                    'location' => 'home',
                ]
            ));

            return redirect()->route('admin.banners.index')
                ->with('success', 'Banner đã được tạo thành công');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Lỗi khi tạo banner: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing a banner
     */
    public function edit(Banner $banner): View
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the banner
     */
    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        try {
            $data = $request->validated();

            // Upload new image if provided
            if ($request->hasFile('image')) {
                $data['image_path'] = $this->images->upload(
                    $request->file('image'),
                    'images/banners',
                    $banner->image_path
                );
            }

            $banner->update($data);

            return redirect()->route('admin.banners.index')
                ->with('success', 'Banner đã được cập nhật');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Lỗi khi cập nhật banner: ' . $e->getMessage());
        }
    }

    /**
     * Delete the banner
     */
    public function destroy(Banner $banner)
    {
        try {
            // Delete image file
            if ($banner->image_path) {
                $this->images->delete($banner->image_path);
            }

            $banner->delete();

            return redirect()->route('admin.banners.index')
                ->with('success', 'Banner đã được xóa');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->with('error', 'Lỗi khi xóa banner: ' . $e->getMessage());
        }
    }

    /**
     * AJAX: Update single field
     */
    public function updateField(Request $request, Banner $banner)
    {
        return $this->handleAjaxFieldUpdate($request, $banner, [
            'allowed_fields' => [
                'title', 'subtitle', 'button_text', 'button_link',
                'sort_order', 'is_active'
            ],
            'rules' => [
                'title' => 'nullable|string|max:255',
                'subtitle' => 'nullable|string|max:500',
                'button_text' => 'nullable|string|max:100',
                'button_link' => 'nullable|url|max:500',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean',
            ],
            'transformers' => [
                'sort_order' => function ($value) {
                    return max(0, (int) $value);
                },
            ],
        ]);
    }

    /**
     * AJAX: Upload image
     */
    public function uploadImage(Request $request, Banner $banner)
    {
        return $this->handleSingleImageUpload(
            $request, $banner,
            dbField: 'image_path',
            folder: 'images/banners',
            imageUrlAccessor: 'image_url',
            successMessage: 'Đã tải ảnh lên',
        );
    }
}
