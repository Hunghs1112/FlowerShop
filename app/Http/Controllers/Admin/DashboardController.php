<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Inquiry;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\MysteryBoxRequest;

class DashboardController extends Controller
{
    public function index()
    {

        $stats = [
            'products' => Product::count(),
            'active_products' => Product::active()->count(),
            'categories' => Category::count(),
            'inquiries' => Inquiry::count(),
            'new_inquiries' => Inquiry::where('status', 'new')->count(),
            'mystery_boxes' => MysteryBoxRequest::count(),
            'new_mystery_boxes' => MysteryBoxRequest::where('status', 'new')->count(),
            'users' => User::where('role', 'customer')->count(),
            'posts' => Post::count(),
            'published_posts' => Post::published()->count(),
        ];

        $recentInquiries = Inquiry::with('user')
            ->latest()
            ->limit(10)
            ->get();

        $recentMysteryBoxes = MysteryBoxRequest::with('user')
            ->latest()
            ->limit(5)
            ->get();

        $lowStockProducts = Product::where('stock', '<=', 5)
            ->where('stock', '>', 0)
            ->with('category')
            ->get();

        return view('admin.dashboard', compact('stats', 'recentInquiries', 'recentMysteryBoxes', 'lowStockProducts'));
    }
}
