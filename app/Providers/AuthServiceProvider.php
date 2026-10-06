<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use App\Models\VipLevel;
use App\Models\Order;
use App\Policies\BannerPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\PagePolicy;
use App\Policies\PostPolicy;
use App\Policies\ProductPolicy;
use App\Policies\UserPolicy;
use App\Policies\VipLevelPolicy;
use App\Policies\OrderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Product::class => ProductPolicy::class,
        Category::class => CategoryPolicy::class,
        Post::class => PostPolicy::class,
        Banner::class => BannerPolicy::class,
        Page::class => PagePolicy::class,
        User::class => UserPolicy::class,
        VipLevel::class => VipLevelPolicy::class,
        Order::class => OrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
