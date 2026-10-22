<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use App\Models\Post;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ImageStorageService;
use App\Services\ProductService;
use App\Services\SettingService;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService,
        protected ProductService $productService,
        protected SettingService $settingService,
        protected ImageStorageService $images,
    ) {}

    public function index()
    {
        $user = auth()->user();
        $bestsellingProducts = $this->productService->getBestSellingProducts(8, null, $user);
        $newArrivalProducts = $this->productService->getNewArrivalProducts(8, null, $user);
        if ($newArrivalProducts->isEmpty()) {
            $query = Product::active()->with(['productImages', 'category', 'subcategory'])->inStock();
            if ($user) {
                $query->visibleToUser($user);
            }
            $newArrivalProducts = $query->latest()->limit(8)->get();
        }
        $categories = $this->categoryService->getActiveCategories();
        $latestPosts = Post::published()->latest('published_at')->limit(3)->get();
        $banners = collect();
        $siteSettings = $this->settingService->getSiteInfo();
        $galleryImages = GalleryImage::active()->orderBy('sort_order')->get();
        $seasonalImages = $this->settingService->getMultiple([
            'seasonal_thu_hero',
            'seasonal_halloween_hero',
            'seasonal_thong_hero',
        ]);
        $homeHeroDescription = $this->settingService->get(
            'home_hero_description',
            'Những đoá hoa được tuyển chọn từ chín vùng đất trên thế giới, bay về Hà Nội và được chăm chút để đến với không gian của bạn.'
        );
        $homeData = [
            'products' => $newArrivalProducts->take(4)->map(fn ($product) => [
                'name' => $product->display_name,
                'origin' => $product->origin ?: __('customer.messages.imported_flowers'),
                'url' => localized_route('products.show', $product->display_slug),
                'image' => $product->getPrimaryImageUrl(),
                'code' => Str::upper(Str::substr((string) preg_replace('/[^A-Za-z0-9]/', '', $product->sku), 0, 3)) ?: 'LNT',
                'status_key' => $product->arrival_status,
            ])->values(),
            'categories' => $categories->take(9)->map(fn ($category) => [
                'name' => $category->display_name,
                'url' => localized_route('products.index', ['categories' => [$category->id]]),
                'image' => $category->image_url,
                'count' => $category->products()->count(),
            ])->values(),
            'posts' => $latestPosts->map(fn ($post) => [
                'title' => $post->display_title,
                'url' => localized_route('blog.show', $post->display_slug),
                'image' => $post->image_url,
                'excerpt' => Str::limit($post->display_excerpt ?? strip_tags($post->display_content), 90),
            ])->values(),
            'hero' => $banners->first() ? [
                'image' => $banners->first()->image_url,
                'title' => $banners->first()->subtitle,
                'label' => $banners->first()->title,
                'url' => $banners->first()->button_link ?: localized_route('products.index'),
                'button' => $banners->first()->button_text ?: __('customer.messages.order_now'),
            ] : null,
            'seasonal' => [
                'autumn_image' => $this->images->url($seasonalImages['seasonal_thu_hero'])
                    ?: asset('images/seasonal/aut_hero.jpg'),
                'halloween_image' => $this->images->url($seasonalImages['seasonal_halloween_hero'])
                    ?: asset('images/seasonal/hlw_hero.jpg'),
                'tree_image' => $this->images->url($seasonalImages['seasonal_thong_hero']),
            ],
            'links' => [
                'products' => localized_route('products.index'),
                'cart' => localized_route('cart.index'),
                'account' => auth()->check() ? localized_route('profile.show') : localized_route('login'),
                'blog' => localized_route('blog.index'),
                'b2c' => localized_route('b2c'),
                'mysteryBox' => localized_route('mystery-box.index'),
                'about' => localized_route('about'),
            ],
        ];

        return view('home.index', compact('bestsellingProducts', 'newArrivalProducts', 'categories', 'latestPosts', 'banners', 'siteSettings', 'homeData', 'homeHeroDescription', 'galleryImages'));
    }
}
