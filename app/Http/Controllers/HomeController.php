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
        $featuredProducts = $this->productService->getFeaturedProducts(8);
        $categories = $this->categoryService->getActiveCategories();
        $latestPosts = Post::published()->latest('published_at')->limit(3)->get();

        $bannerKey = 'home';

        return view('home.index', compact('featuredProducts', 'categories', 'latestPosts', 'bannerKey'));
    }
}
