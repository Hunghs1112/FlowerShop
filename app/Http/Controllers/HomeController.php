<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\ProductService;
use App\Models\Post;

class HomeController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService,
        protected ProductService $productService
    ) {}

    public function index()
    {
        $bestsellingProducts = $this->productService->getBestsellingProducts(8);
        $categories = $this->categoryService->getActiveCategories();
        $latestPosts = Post::published()->latest('published_at')->limit(3)->get();
        $siteSettings = [
            'site_name' => config('app.name', 'Lâm Nhiên Thảo'),
            'instagram_url' => 'https://instagram.com/lamnhienthao'
        ];

        return view('home.index', compact('bestsellingProducts', 'categories', 'latestPosts', 'siteSettings'));
    }
}
