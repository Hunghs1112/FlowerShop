<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVipLevelRequest;
use App\Http\Requests\UpdateVipLevelRequest;
use App\Models\VipLevel;
use App\Models\Product;
use App\Repositories\VipLevelRepository;
use App\Services\AjaxFieldService;
use Illuminate\Http\Request;

class VipLevelController extends Controller
{
    protected VipLevelRepository $vipLevels;
    protected AjaxFieldService $ajaxFieldService;

    public function __construct(
        VipLevelRepository $vipLevels,
        AjaxFieldService $ajaxFieldService
    ) {
        $this->vipLevels = $vipLevels;
        $this->ajaxFieldService = $ajaxFieldService;
        
    }

    /**
     * Display a listing of VIP levels
     */
    public function index()
    {
        $vipLevels = VipLevel::withCount(['users', 'products'])
            ->orderBy('priority')
            ->get();

        return view('admin.vip-levels.index', compact('vipLevels'));
    }

    /**
     * Show the form for creating a new VIP level
     */
    public function create()
    {
        return view('admin.vip-levels.create');
    }

    /**
     * Store a newly created VIP level
     */
    public function store(StoreVipLevelRequest $request)
    {

        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active', true);

        $this->vipLevels->create($validated);

        return redirect()->route('admin.vip-levels.index')
                        ->with('success', 'VIP level đã được tạo thành công');
    }

    /**
     * Show the form for editing the specified VIP level
     */
    public function edit(VipLevel $vipLevel)
    {

        $vipLevel->load(['users', 'products']);
        
        // Get all products for assignment UI
        $allProducts = Product::active()
                              ->orderBy('name')
                              ->get();
        
        return view('admin.vip-levels.edit', compact('vipLevel', 'allProducts'));
    }

    /**
     * Update the specified VIP level
     */
    public function update(UpdateVipLevelRequest $request, VipLevel $vipLevel)
    {

        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active');

        $vipLevel->update($validated);

        // Sync products
        if ($request->has('product_ids')) {
            $vipLevel->products()->sync($request->input('product_ids', []));
        }

        return redirect()->route('admin.vip-levels.edit', $vipLevel)
                        ->with('success', 'VIP level đã được cập nhật thành công');
    }

    /**
     * Update products for VIP level (AJAX endpoint)
     */
    public function updateProducts(Request $request, VipLevel $vipLevel)
    {

        $validated = $request->validate([
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $vipLevel->products()->sync($request->input('product_ids', []));

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật danh sách sản phẩm',
            'count' => count($request->input('product_ids', [])),
        ]);
    }

    /**
     * Remove the specified VIP level
     */
    public function destroy(VipLevel $vipLevel)
    {

        // Check if any users are assigned to this VIP level
        if ($vipLevel->users()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Không thể xóa VIP level đang có người dùng. Vui lòng chuyển người dùng sang VIP level khác trước.');
        }

        $vipLevel->delete();

        return redirect()->route('admin.vip-levels.index')
                        ->with('success', 'VIP level đã được xóa thành công');
    }
}
