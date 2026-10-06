<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Post;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\SettingService;

class HomeController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService,
        protected ProductService $productService,
        protected SettingService $settingService,
    ) {}

    public function index()
    {
        $user = auth()->user();
        $bestsellingProducts = $this->productService->getBestSellingProducts(8, null, $user);
        $categories = $this->categoryService->getActiveCategories();
        $latestPosts = Post::published()->latest('published_at')->limit(3)->get();
        $banners = Banner::active()->forLocation('home')->ordered()->get();
        $siteSettings = $this->settingService->getSiteInfo();

        return view('home.index', compact('bestsellingProducts', 'categories', 'latestPosts', 'banners', 'siteSettings'));
    }
}
