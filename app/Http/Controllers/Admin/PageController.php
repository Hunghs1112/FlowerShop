<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesAjaxFieldUpdates;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Http\Responses\AjaxResponse;
use App\Models\Page;
use App\Repositories\PageRepository;
use App\Services\ImageStorageService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    use HandlesAjaxFieldUpdates;

    protected PageRepository $pages;
    protected ImageStorageService $images;

    public function __construct(PageRepository $pages, ImageStorageService $images)
    {
        $this->pages = $pages;
        $this->images = $images;
    }

    /**
     * Display a listing of pages
     */
    public function index(Request $request): View
    {
        $query = Page::query()->where(function ($query) {
            $query->whereNotIn('slug', Page::STATIC_SLUGS)
                ->orWhereIn('slug', [...Page::POLICY_SLUGS, ...Page::SEASONAL_SLUGS, ...Page::GUIDE_SLUGS]);
        });

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->input('type') === 'policy') {
            $query->whereIn('slug', Page::POLICY_SLUGS);
        } elseif ($request->input('type') === 'regular') {
            $query->whereNotIn('slug', Page::STATIC_SLUGS);
        }

        $filters = $this->buildFilters($request);
        foreach ($filters as $field => $value) {
            if ($value !== null) {
                $query->where($field, $value);
            }
        }

        $pages = $query->latest()->paginate(min(max((int) $request->input('per_page', 15), 1), 100));

        return view('admin.pages.index', [
            'pages'  => $pages,
            'search' => $request->input('search'),
        ]);
    }

    /**
     * Show the form for creating a new page
     */
    public function create(): View
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created page
     */
    public function store(StorePageRequest $request)
    {
        $page = Page::create($request->validated());

        return redirect()->route('admin.pages.index')
            ->with('success', 'Tạo trang thành công');
    }

    /**
     * Show the form for editing a page
     */
    public function edit(Page $page): View
    {
        $isPolicy = in_array($page->slug, Page::POLICY_SLUGS, true);
        $isSeasonal = in_array($page->slug, Page::SEASONAL_SLUGS, true);
        $isGuide = in_array($page->slug, Page::GUIDE_SLUGS, true);
        abort_if(in_array($page->slug, Page::STATIC_SLUGS, true) && !$isPolicy && !$isSeasonal && !$isGuide, 404);
        return view('admin.pages.edit', compact('page', 'isPolicy', 'isSeasonal', 'isGuide'));
    }

    /**
     * Display a single page (preview / quick view)
     */
    public function show(Page $page)
    {
        return redirect()->route('admin.pages.edit', $page);
    }

    /**
     * Update the page
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        $page->update($request->validated());

        return redirect()->route('admin.pages.index')
            ->with('success', 'Cập nhật trang thành công');
    }

    /**
     * Delete the page
     */
    public function destroy(Page $page)
    {
        if (in_array($page->slug, [...Page::STATIC_SLUGS, ...Page::GUIDE_SLUGS], true)) {
            abort(404);
        }
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Xóa trang thành công');
    }

    /**
     * AJAX: Auto-save single field
     */
    public function autoSave(Request $request, Page $page)
    {
        return $this->updateField($request, $page);
    }

    /**
     * AJAX: Update single field
     */
    public function updateField(Request $request, Page $page)
    {
        $isPolicy = in_array($page->slug, Page::POLICY_SLUGS, true);
        $isSeasonal = in_array($page->slug, Page::SEASONAL_SLUGS, true);
        $isGuide = in_array($page->slug, Page::GUIDE_SLUGS, true);
        abort_if(in_array($page->slug, Page::STATIC_SLUGS, true) && !$isPolicy && !$isSeasonal && !$isGuide, 404);

        $allowedFields = $isPolicy
            ? ['title', 'policy_intro', 'policy_updated_at_display', 'policy_content_override', 'is_active']
            : (($isSeasonal || $isGuide)
                ? ['title', 'content', 'is_active']
                : ['title', 'slug', 'content', 'is_active', 'meta_title', 'meta_description', 'header_image', 'hide_header_overlay']);
        return $this->handleAjaxFieldUpdate($request, $page, [
            'allowed_fields' => $allowedFields,
            'rules' => [
                'title' => 'required|string|max:255',
                'slug' => ['nullable', 'string', 'max:255', 'unique:pages,slug,' . $page->id, \Illuminate\Validation\Rule::notIn(Page::STATIC_SLUGS)],
                'content' => $isSeasonal ? 'required|json' : 'required|string',
                'is_active' => 'boolean',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'header_image' => 'nullable|string|max:500',
                'hide_header_overlay' => 'boolean',
                'policy_intro' => 'nullable|string|max:1000',
                'policy_updated_at_display' => 'nullable|string|max:60',
                'policy_content_override' => 'nullable|string|max:200000',
            ],
        ]);
    }

    /**
     * AJAX: Upload header image
     */
    public function uploadHeaderImage(Request $request, Page $page)
    {
        abort_if(in_array($page->slug, Page::STATIC_SLUGS, true), 404);

        $maxKb = (int) config('upload.limits.page_header.max_size', 4096);
        $request->validate([
            'file' => "required|image|mimes:jpeg,png,jpg,gif,webp|max:{$maxKb}",
        ]);

        $oldPath = $page->header_image;
        $imagePath = $this->images->upload(
            $request->file('file'),
            config('upload.disks.folders.page_header', 'images/pages'),
            $oldPath,
            'page_header'
        );

        $page->update(['header_image' => $imagePath]);

        return response()->json([
            'success' => true,
            'url' => $page->header_image_url,
        ]);
    }

    /**
     * Build filters from request
     */
    protected function buildFilters(Request $request): array
    {
        $filters = [];

        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $filters['is_active'] = true;
            } elseif ($status === 'inactive') {
                $filters['is_active'] = false;
            }
        }

        return $filters;
    }

}
