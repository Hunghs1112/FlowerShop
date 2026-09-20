<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * CatalogController - Quản lý tổng hợp Danh mục, Danh mục phụ và Sản phẩm
 * Giao diện thống nhất với tab navigation để dễ dàng quản lý
 */
class CatalogController extends Controller
{
    /**
     * Hiển thị giao diện quản lý catalog tổng hợp
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Xác định tab hiện tại (mặc định là categories)
        $activeTab = $request->input('tab', 'categories');
        
        // Validate tab
        if (!in_array($activeTab, ['categories', 'subcategories', 'products'])) {
            $activeTab = 'categories';
        }

        $data = [
            'activeTab' => $activeTab,
            'categories' => collect([]),
            'subcategories' => collect([]),
            'products' => collect([]),
            'allCategories' => Category::orderBy('name')->get(),
        ];

        // Load data dựa trên tab hiện tại
        switch ($activeTab) {
            case 'categories':
                $data['categories'] = $this->getCategories($request);
                break;
                
            case 'subcategories':
                $data['subcategories'] = $this->getSubcategories($request);
                break;
                
            case 'products':
                $data['products'] = $this->getProducts($request);
                break;
        }

        return view('admin.catalog.index', $data);
    }

    /**
     * Lấy danh sách Categories với filters
     */
    protected function getCategories(Request $request)
    {
        $query = Category::withCount(['products', 'subcategories']);

        // Tìm kiếm
        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Lọc trạng thái
        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        return $query->orderBy('sort_order')->paginate(20)->appends($request->except('page'));
    }

    /**
     * Lấy danh sách Subcategories với filters
     */
    protected function getSubcategories(Request $request)
    {
        $query = Subcategory::with('category')->withCount('products');

        // Tìm kiếm
        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Lọc theo danh mục cha
        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        // Lọc trạng thái
        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        return $query->orderBy('sort_order')->paginate(20)->appends($request->except('page'));
    }

    /**
     * Lấy danh sách Products với filters
     */
    protected function getProducts(Request $request)
    {
        $query = Product::with(['category', 'subcategory', 'productImages']);

        // Tìm kiếm
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        // Lọc theo danh mục
        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        // Lọc theo danh mục phụ
        if ($subcategoryId = $request->input('subcategory_id')) {
            $query->where('subcategory_id', $subcategoryId);
        }

        // Lọc trạng thái
        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        return $query->latest()->paginate(20)->appends($request->except('page'));
    }
}
