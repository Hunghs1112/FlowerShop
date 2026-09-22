<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * CatalogController - Quản lý tổng hợp Danh mục, Danh mục phụ và Sản phẩm
 */
class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = in_array($request->input('tab'), ['categories', 'subcategories', 'products'])
            ? $request->input('tab')
            : 'categories';

        $allCategories = Category::orderBy('name')->get();

        $categories   = collect();
        $subcategories = collect();
        $products     = collect();

        match ($activeTab) {
            'categories'   => $categories   = $this->getCategories($request),
            'subcategories' => $subcategories = $this->getSubcategories($request),
            'products'     => $products     = $this->getProducts($request),
        };

        return view('admin.catalog.index', compact(
            'activeTab', 'allCategories', 'categories', 'subcategories', 'products'
        ));
    }

    protected function getCategories(Request $request)
    {
        $query = Category::withCount(['products', 'subcategories']);

        if ($s = $request->input('search')) {
            $query->where('name', 'like', "%{$s}%");
        }
        if ($request->input('status') === 'active') {
            $query->where('is_active', true);
        } elseif ($request->input('status') === 'inactive') {
            $query->where('is_active', false);
        }

        return $query->orderBy('sort_order')->get();
    }

    protected function getSubcategories(Request $request)
    {
        $query = Subcategory::with('category')->withCount('products');

        if ($s = $request->input('search')) {
            $query->where('name', 'like', "%{$s}%");
        }
        if ($cat = $request->input('category_id')) {
            $query->where('category_id', $cat);
        }
        if ($request->input('status') === 'active') {
            $query->where('is_active', true);
        } elseif ($request->input('status') === 'inactive') {
            $query->where('is_active', false);
        }

        return $query->orderBy('sort_order')->get();
    }

    protected function getProducts(Request $request)
    {
        $query = Product::with(['category', 'subcategory', 'productImages']);

        if ($s = $request->input('search')) {
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")->orWhere('sku', 'like', "%{$s}%");
            });
        }
        if ($cat = $request->input('category_id')) {
            $query->where('category_id', $cat);
        }
        if ($sub = $request->input('subcategory_id')) {
            $query->where('subcategory_id', $sub);
        }
        if ($request->input('status') === 'active') {
            $query->where('is_active', true);
        } elseif ($request->input('status') === 'inactive') {
            $query->where('is_active', false);
        }

        return $query->latest()->get();
    }
}
