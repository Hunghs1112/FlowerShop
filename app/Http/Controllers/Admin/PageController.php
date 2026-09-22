<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesAjaxFieldUpdates;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Http\Responses\AjaxResponse;
use App\Models\Page;
use App\Repositories\PageRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    use HandlesAjaxFieldUpdates;

    protected PageRepository $pages;

    public function __construct(PageRepository $pages)
    {
        $this->pages = $pages;
    }

    /**
     * Display a listing of pages
     */
    public function index(Request $request): View
    {
        $query = \App\Models\Page::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $filters = $this->buildFilters($request);
        foreach ($filters as $field => $value) {
            if ($value !== null) {
                $query->where($field, $value);
            }
        }

        $pages = $query->latest()->paginate($request->input('per_page', 15));

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
        return view('admin.pages.edit', compact('page'));
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
        return $this->handleAjaxFieldUpdate($request, $page, [
            'allowed_fields' => [
                'title', 'slug', 'content', 'is_active',
                'meta_title', 'meta_description'
            ],
            'rules' => [
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
                'content' => 'required|string',
                'is_active' => 'boolean',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
            ],
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
