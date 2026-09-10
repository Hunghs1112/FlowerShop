<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService,
        protected ProductService $productService
    ) {}

    public function index()
    {
        $categories = Category::active()
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(string $slug, Request $request)
    {
        // Support both EN and VI slugs
        $category = Category::where('slug', $slug)
            ->orWhere('slug_en', $slug)
            ->active()
            ->with(['children'])
            ->firstOrFail();

        // Get all descendant category IDs for filtering
        $categoryIds = $this->categoryService->getDescendantIds($category);

        $filters = [
            'category_ids' => $categoryIds,
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'in_stock' => $request->boolean('in_stock'),
            'sort_by' => $request->input('sort_by', 'latest'),
            'per_page' => 12,
        ];

        $products = $this->productService->filterProducts($filters);
        $breadcrumb = $this->categoryService->getBreadcrumb($category);

        return view('categories.show', compact('category', 'products', 'breadcrumb', 'filters'));
    }
}
