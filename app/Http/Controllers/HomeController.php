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
        $newArrivalProducts = $this->productService->getNewArrivalProducts(8, null, $user);
        $categories = $this->categoryService->getActiveCategories();
        $latestPosts = Post::published()->latest('published_at')->limit(3)->get();
        $banners = Banner::active()->forLocation('home')->ordered()->get();
        $siteSettings = $this->settingService->getSiteInfo();
        $homeData = [
            'products' => $newArrivalProducts->take(4)->map(fn ($product) => [
                'name' => $product->display_name,
                'origin' => $product->origin ?: 'Hoa nhập khẩu',
                'url' => route('products.show', $product->display_slug),
                'image' => $product->getPrimaryImageUrl(),
            ])->values(),
            'categories' => $categories->take(9)->map(fn ($category) => [
                'name' => $category->display_name,
                'url' => route('products.index', ['categories' => [$category->id]]),
                'image' => $category->image_url,
                'count' => $category->products()->count(),
            ])->values(),
            'posts' => $latestPosts->map(fn ($post) => [
                'title' => $post->title,
                'url' => route('blog.show', $post->slug),
                'image' => $post->image_url,
                'excerpt' => \Illuminate\Support\Str::limit($post->excerpt ?? strip_tags($post->content), 90),
            ])->values(),
            'hero' => $banners->first() ? [
                'image' => $banners->first()->image_url,
                'title' => $banners->first()->subtitle,
                'label' => $banners->first()->title,
                'url' => $banners->first()->button_link ?: route('products.index'),
                'button' => $banners->first()->button_text ?: 'Đặt hoa ngay',
            ] : null,
            'links' => [
                'products' => route('products.index'),
                'cart' => route('cart.index'),
                'account' => auth()->check() ? route('profile.show') : route('login'),
                'blog' => route('blog.index'),
                'contact' => route('contact'),
                'mysteryBox' => route('mystery-box.index'),
                'about' => route('about'),
            ],
        ];

        return view('home.index', compact('bestsellingProducts', 'newArrivalProducts', 'categories', 'latestPosts', 'banners', 'siteSettings', 'homeData'));
    }
}
