<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesAjaxFieldUpdates;
use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductCollectionController extends Controller
{
    use HandlesAjaxFieldUpdates;

    public function index(): View
    {
        $collections = ProductCollection::withCount('products')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.product-collections.index', compact('collections'));
    }

    public function create(): View
    {
        $collection = new ProductCollection;
        $allProducts = $this->getAllProducts();

        return view('admin.product-collections.create', compact('collection', 'allProducts'));
    }

    public function store(Request $request)
    {
        [$data, $productIds] = $this->validatePayload($request);
        $collection = ProductCollection::create($data);
        $this->syncProducts($collection, $productIds);

        return redirect()->route('admin.product-collections.index')
            ->with('success', 'Đã tạo bộ sưu tập');
    }

    public function edit(ProductCollection $productCollection): View
    {
        $allProducts = $this->getAllProducts();
        $selectedIds = $productCollection->products()->pluck('products.id')->all();

        return view('admin.product-collections.edit', compact('productCollection', 'allProducts', 'selectedIds'));
    }

    public function update(Request $request, ProductCollection $productCollection)
    {
        [$data, $productIds] = $this->validatePayload($request);
        $productCollection->update($data);
        $this->syncProducts($productCollection, $productIds);

        return redirect()->route('admin.product-collections.index')
            ->with('success', 'Đã cập nhật bộ sưu tập');
    }

    public function destroy(ProductCollection $productCollection)
    {
        $productCollection->delete();

        return redirect()->route('admin.product-collections.index')
            ->with('success', 'Đã xóa bộ sưu tập');
    }

    public function autoSave(Request $request, ProductCollection $productCollection)
    {
        $validated = $request->validate([
            'field' => 'required|string',
            'value' => 'nullable',
        ]);

        $field = $validated['field'];
        abort_unless(in_array($field, ['name', 'criterion', 'accent_color', 'is_active', 'sort_order'], true), 422);

        $value = $validated['value'];
        if (in_array($field, ['is_active'], true)) {
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }
        if ($field === 'sort_order') {
            $value = (int) $value;
        }
        if ($field === 'accent_color' && $value !== null && $value !== '') {
            abort_unless(preg_match('/^#[0-9A-Fa-f]{6}$/', $value), 422, 'Mã màu không hợp lệ');
        }

        $productCollection->update([$field => $value]);

        return response()->json(['success' => true, 'value' => $productCollection->{$field}]);
    }

    protected function getAllProducts()
    {
        return Product::with('productImages')
            ->orderBy('name')
            ->get();
    }

    protected function validatePayload(Request $request): array
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'criterion' => 'nullable|string|max:255',
            'accent_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'integer|exists:products,id',
        ]);

        $data = [
            'name' => $validated['name'],
            'criterion' => $validated['criterion'] ?? null,
            'accent_color' => $validated['accent_color'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? false),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ];

        return [$data, $validated['product_ids'] ?? []];
    }

    protected function syncProducts(ProductCollection $collection, array $productIds): void
    {
        $sync = [];
        foreach (array_values(array_unique(array_filter($productIds))) as $i => $id) {
            $sync[(int) $id] = ['sort_order' => $i];
        }
        $collection->products()->sync($sync);
    }
}
