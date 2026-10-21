<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\ProductImage;
use App\Models\ProductVariantImage;
use App\Models\Setting;
use App\Models\Subcategory;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\ProductWatermarkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected CategoryService $categoryService,
        protected ProductWatermarkService $productWatermark
    ) {}

    /**
     * Display product listing with filters and search
     */
    public function index(FilterProductRequest $request)
    {
        // Build filters array from validated request
        $filters = [
            'category_ids' => $request->getCategoryIds(),
            'subcategory_ids' => $request->input('subcategories', []),
            'min_price' => $request->getPriceRange()['min'],
            'max_price' => $request->getPriceRange()['max'],
            'in_stock' => $request->boolean('in_stock'),
            'search' => $request->getSearchQuery(),
            'sort_by' => $request->getSortOption(),
            'per_page' => 12,
            'user' => auth()->user(), // Pass authenticated user for VIP filtering
        ];

        // Get filtered products
        $products = $this->productService->filterProducts($filters);

        // Get categories for filter sidebar with product counts
        $categories = $this->categoryService->getActiveCategories();

        // Get subcategories with product counts
        $subcategories = Subcategory::where('is_active', true)
            ->with('category')
            ->withCount('products')
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();

        // Active category for display in hero
        $activeCategory = null;
        $categoryIds = $filters['category_ids'];
        if (! empty($categoryIds)) {
            $activeCategory = Category::find($categoryIds[0]);
        }

        // Get active filter chips for display
        $activeFilterChips = $request->getActiveFilterChips();

        // Check if this is an AJAX request for autocomplete results
        if ($request->wantsJson() && $request->has('autocomplete')) {
            return response()->json([
                'success' => true,
                'data' => $this->productService->autocomplete($request->getSearchQuery() ?? ''),
            ]);
        }

        // Get banner image for the page
        $bannerImage = null;
        if ($activeCategory && $activeCategory->banner_image) {
            // Use category banner if available
            $bannerImage = $activeCategory->banner_image_url;
        }

        // Suggestion collections (theo màu / tiêu chí) hiển thị dưới grid
        $suggestionCollections = ProductCollection::active()
            ->with(['products' => function ($q) {
                $q->active()->with('productImages')
                    ->orderBy('collection_product.sort_order')
                    ->limit(8);
            }])
            ->orderBy('sort_order')
            ->get()
            ->filter(fn ($c) => $c->products->isNotEmpty())
            ->values();

        return view('products.index', compact(
            'products',
            'categories',
            'subcategories',
            'filters',
            'activeCategory',
            'bannerImage',
            'activeFilterChips',
            'suggestionCollections'
        ));
    }

    /**
     * Display a single product
     */
    public function show(string $identifier)
    {
        // A numeric slug is valid (for example, a product named "123").
        // Prefer an ID match for legacy links, then fall back to either slug.
        $product = Product::where(function ($query) use ($identifier) {
            if (is_numeric($identifier)) {
                $query->where('id', $identifier);
            }

            $query->orWhere('slug', $identifier)
                ->orWhere('slug_en', $identifier);
        })
            ->active()
            ->with(['productImages', 'category', 'subcategory.category', 'variants' => function ($query) {
                $query->where('is_active', true)->with('images');
            }])
            ->firstOrFail();

        // CRITICAL: Backend VIP authorization check
        $user = auth()->user();
        if (! $product->isAccessibleTo($user)) {
            abort(404); // Product not found for this VIP level
        }

        // Get recommended products (same subcategory first, then same category, or featured)
        $recommendedQuery = Product::active()
            ->inStock()
            ->where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                if ($product->subcategory_id) {
                    // Prioritize same subcategory
                    $query->where('subcategory_id', $product->subcategory_id);
                } else {
                    // Fall back to category or featured
                    $query->where('category_id', $product->category_id)
                        ->orWhere('is_featured', true);
                }
            })
            ->with('productImages');

        // Apply VIP filtering to recommended products
        if ($user) {
            $recommendedQuery->visibleToUser($user);
        }

        $recommendedProducts = $recommendedQuery->limit(4)->get();

        // Get recently viewed or random products
        $recentlyViewed = Product::active()
            ->inStock()
            ->where('id', '!=', $product->id)
            ->with('productImages')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('products.detail', compact('product', 'recommendedProducts', 'recentlyViewed'));
    }

    public function watermarkedImage(string $type, int $id)
    {
        $media = match ($type) {
            'product' => ProductImage::with('product')->findOrFail($id),
            'variant' => ProductVariantImage::with('productVariant.product')->findOrFail($id),
            default => abort(404),
        };
        $product = $media instanceof ProductImage ? $media->product : $media->productVariant->product;

        abort_unless($media->image_path && $product?->is_active && $product->isAccessibleTo(auth()->user()), 404);
        abort_if($media instanceof ProductImage && ! $media->isImage(), 404);

        $path = preg_replace('#^/?images/#', '', $media->image_path);
        abort_unless(Storage::disk('public')->exists($path), 404);

        $logoPath = Setting::get('product_watermark_logo');
        if ($logoPath === '') {
            return Storage::disk('public')->response($path);
        }

        $logoContents = $logoPath && Storage::disk('public')->exists($logoPath)
            ? Storage::disk('public')->get($logoPath)
            : file_get_contents(public_path('images/brand/lnt-logo.png'));
        $variant = Setting::get('product_watermark_variant', 'color');
        $position = Setting::get('product_watermark_position', 'br');
        $result = $this->productWatermark->render(
            Storage::disk('public')->get($path),
            $logoContents,
            [
                'variant' => in_array($variant, ['color', 'white', 'brown', 'cream'], true) ? $variant : 'color',
                'position' => in_array($position, ['tl', 'tc', 'tr', 'ml', 'mc', 'mr', 'bl', 'bc', 'br'], true) ? $position : 'br',
                'size' => min(60, max(8, (int) Setting::get('product_watermark_size', 22))),
                'margin' => min(15, max(0, (float) Setting::get('product_watermark_margin', 4))),
                'opacity' => min(100, max(10, (int) Setting::get('product_watermark_opacity', 100))),
            ]
        );
        $filename = pathinfo($path, PATHINFO_FILENAME).'-watermark.'.$result['extension'];

        return response($result['contents'], 200, [
            'Content-Type' => $result['mime'],
            'Content-Disposition' => 'inline; filename="'.$filename.'"',
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }

    /**
     * API endpoint for product search (autocomplete)
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');

        // Minimum 2 characters
        if (strlen($query) < 2) {
            return response()->json(['products' => []]);
        }

        // Sanitize
        $query = trim(preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $query));

        $products = $this->productService->search($query, 10);

        return response()->json(['products' => $products]);
    }
}
