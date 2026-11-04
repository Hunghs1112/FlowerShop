<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesAjaxFieldUpdates;
use App\Models\DiscountGroup;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DiscountGroupController extends Controller
{
    use HandlesAjaxFieldUpdates;

    public function index(): View
    {
        $groups = DiscountGroup::withCount('products')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.discount-groups.index', compact('groups'));
    }

    public function create(): View
    {
        $group = new DiscountGroup;
        $allProducts = $this->getAllProducts();

        return view('admin.discount-groups.create', compact('group', 'allProducts'));
    }

    public function store(Request $request)
    {
        [$data, $productIds] = $this->validatePayload($request);
        $group = DiscountGroup::create($data);
        $this->syncProducts($group, $productIds);

        return redirect()->route('admin.discount-groups.index')
            ->with('success', 'Đã tạo nhóm ưu đãi');
    }

    public function edit(DiscountGroup $discountGroup): View
    {
        $group = $discountGroup;
        $allProducts = $this->getAllProducts();
        $selectedIds = $discountGroup->products()->pluck('products.id')->all();

        return view('admin.discount-groups.edit', compact('discountGroup', 'group', 'allProducts', 'selectedIds'));
    }

    public function update(Request $request, DiscountGroup $discountGroup)
    {
        [$data, $productIds] = $this->validatePayload($request);
        $discountGroup->update($data);
        $this->syncProducts($discountGroup, $productIds);

        return redirect()->route('admin.discount-groups.index')
            ->with('success', 'Đã cập nhật nhóm ưu đãi');
    }

    public function destroy(DiscountGroup $discountGroup)
    {
        $discountGroup->delete();

        return redirect()->route('admin.discount-groups.index')
            ->with('success', 'Đã xóa nhóm ưu đãi');
    }

    public function autoSave(Request $request, DiscountGroup $discountGroup)
    {
        $validated = $request->validate([
            'field' => 'required|string',
            'value' => 'nullable',
        ]);

        $field = $validated['field'];
        abort_unless(in_array($field, ['name', 'name_en', 'description', 'discount_percent', 'is_active', 'sort_order'], true), 422);

        $value = $validated['value'];
        if ($field === 'is_active') {
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }
        if (in_array($field, ['discount_percent', 'sort_order'], true)) {
            $value = (int) $value;
        }

        $discountGroup->update([$field => $value]);

        return response()->json(['success' => true, 'value' => $discountGroup->{$field}]);
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
            'name_en' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:255',
            'discount_percent' => 'required|integer|min:1|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'integer|exists:products,id',
        ]);

        $data = [
            'name' => $validated['name'],
            'name_en' => $validated['name_en'] ?? null,
            'description' => $validated['description'] ?? null,
            'discount_percent' => (int) $validated['discount_percent'],
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ];

        return [$data, $validated['product_ids'] ?? []];
    }

    protected function syncProducts(DiscountGroup $group, array $productIds): void
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', $productIds))));

        // Each product belongs to at most one group (unique product_id on the pivot),
        // so release them from other groups before attaching to this one.
        DiscountGroup::whereKeyNot($group->id)
            ->whereHas('products', fn ($q) => $q->whereIn('products.id', $ids))
            ->get()
            ->each(fn ($other) => $other->products()->detach($ids));

        $group->products()->sync($ids);
    }
}
