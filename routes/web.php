<?php

use App\Http\Controllers\B2cController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuickOrderController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Admin\CatalogController;
use Illuminate\Support\Facades\Route;

// ============================================================
// Customer-facing routes
// ============================================================

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/san-pham', [ProductController::class, 'index'])->name('products.index');
Route::get('/san-pham/{product}', [ProductController::class, 'show'])->name('products.show');

// Categories
Route::get('/danh-muc', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/danh-muc/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Blog
Route::get('/bai-viet', [PostController::class, 'index'])->name('blog.index');
Route::get('/bai-viet/{post}', [PostController::class, 'show'])->name('blog.show');

// Pages
Route::get('/ve-chung-toi', [PageController::class, 'about'])->name('about');
Route::get('/lien-he', [PageController::class, 'contact'])->name('contact');
Route::post('/lien-he', [PageController::class, 'contactSubmit'])->name('contact.store');
Route::get('/trang/{slug}', [PageController::class, 'policy'])->name('policy');

// Cart
Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
Route::post('/gio-hang/them', [CartController::class, 'add'])->name('cart.add');
Route::patch('/gio-hang/{cartItem}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/gio-hang/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::delete('/gio-hang', [CartController::class, 'clear'])->name('cart.clear');

// Quick order
Route::post('/dat-hang-nhanh', [QuickOrderController::class, 'store'])->name('quick-order.store');

// B2C landing & registration
Route::get('/b2c', [B2cController::class, 'index'])->name('b2c');
Route::post('/b2c', [B2cController::class, 'store'])->name('b2c.store');

// Auth
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

// Password Reset
Route::get('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// ============================================================
// Authenticated routes
// ============================================================
Route::middleware(['auth'])->group(function () {
    // Checkout
    Route::get('/thanh-toan', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/thanh-toan', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/thanh-toan/thanh-cong/{inquiry?}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Mystery Box
    Route::get('/hop-hoa-bi-an', [\App\Http\Controllers\MysteryBoxController::class, 'index'])->name('mystery-box.index');
    Route::post('/hop-hoa-bi-an', [\App\Http\Controllers\MysteryBoxController::class, 'store'])->name('mystery-box.store');
    Route::get('/hop-hoa-bi-an/thanh-cong/{request}', [\App\Http\Controllers\MysteryBoxController::class, 'success'])->name('mystery-box.success');

    // Profile
    Route::get('/tai-khoan', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/tai-khoan', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/tai-khoan/mat-khau', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Favorites
    Route::get('/yeu-thich', [\App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/yeu-thich', [\App\Http\Controllers\FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/yeu-thich/{id}', [\App\Http\Controllers\FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Chat
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/messages', [\App\Http\Controllers\ChatController::class, 'messages'])->name('chat.messages');
    Route::get('/chat/poll', [\App\Http\Controllers\ChatController::class, 'poll'])->name('chat.poll');
    Route::get('/chat/unread-count', [\App\Http\Controllers\ChatController::class, 'unreadCount'])->name('chat.unread-count');
    Route::post('/chat/send', [\App\Http\Controllers\ChatController::class, 'store'])->name('chat.send');
});

// ============================================================
// API routes
// ============================================================
Route::get('/api/products', [ApiProductController::class, 'getProducts'])->name('api.products');
Route::get('/api/search', [SearchController::class, 'autocomplete'])->name('api.search.autocomplete');

// ============================================================
// Utility routes
// ============================================================
Route::get('/setup-clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return response('<pre>' . \Illuminate\Support\Facades\Artisan::output() . '</pre>');
})->name('setup.clear');

// ============================================================
// Admin routes
// ============================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Catalog unified management (Gộp 3 phần: Categories, Subcategories, Products)
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');

    // Catalog management - Use admin.catalog.index (unified)
    // Individual routes still work for create/edit, but sidebar points to catalog
    // To fully disable: comment out these resources and use catalog controller only
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('subcategories', \App\Http\Controllers\Admin\SubcategoryController::class);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);
    Route::post('pages/{page}/upload-header-image', [\App\Http\Controllers\Admin\PageController::class, 'uploadHeaderImage'])->name('pages.uploadHeaderImage');
    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);

    // AJAX Auto-save endpoints for Products
    Route::patch('products/{product}/update-field', [\App\Http\Controllers\Admin\ProductController::class, 'updateField'])->name('products.updateField');
    Route::post('products/{product}/upload-file', [\App\Http\Controllers\Admin\ProductController::class, 'uploadFile'])->name('products.uploadFile');
    Route::delete('products/{product}/images/{image}', [\App\Http\Controllers\Admin\ProductController::class, 'deleteImage'])->name('products.deleteImage');
    Route::delete('products/{product}/videos/{video}', [\App\Http\Controllers\Admin\ProductController::class, 'deleteVideo'])->name('products.deleteVideo');
    Route::post('products/{product}/images/{image}/set-primary', [\App\Http\Controllers\Admin\ProductController::class, 'setPrimaryImage'])->name('products.setPrimaryImage');

    // Import Products
    Route::get('products/import', [\App\Http\Controllers\Admin\ProductController::class, 'import'])->name('products.import');
    Route::post('products/import', [\App\Http\Controllers\Admin\ProductController::class, 'processImport'])->name('products.processImport');
    Route::get('products/template', [\App\Http\Controllers\Admin\ProductController::class, 'downloadTemplate'])->name('products.template');

    // Product Variants Management
    Route::get('products/{product}/variants', [\App\Http\Controllers\Admin\ProductVariantController::class, 'index'])->name('products.variants.index');
    Route::get('products/{product}/variants/create', [\App\Http\Controllers\Admin\ProductVariantController::class, 'create'])->name('products.variants.create');
    Route::post('products/{product}/variants', [\App\Http\Controllers\Admin\ProductVariantController::class, 'store'])->name('products.variants.store');
    Route::get('products/{product}/variants/{variant}/edit', [\App\Http\Controllers\Admin\ProductVariantController::class, 'edit'])->name('products.variants.edit');
    Route::put('products/{product}/variants/{variant}', [\App\Http\Controllers\Admin\ProductVariantController::class, 'update'])->name('products.variants.update');
    Route::delete('products/{product}/variants/{variant}', [\App\Http\Controllers\Admin\ProductVariantController::class, 'destroy'])->name('products.variants.destroy');
    Route::post('products/{product}/variants/{variant}/upload-images', [\App\Http\Controllers\Admin\ProductVariantController::class, 'uploadImages'])->name('products.variants.uploadImages');

    // AJAX Auto-save endpoints for Categories
    Route::patch('categories/{category}/auto-save', [\App\Http\Controllers\Admin\CategoryController::class, 'autoSave'])->name('categories.autoSave');
    Route::post('categories/{category}/upload-image', [\App\Http\Controllers\Admin\CategoryController::class, 'uploadImage'])->name('categories.uploadImage');
    Route::delete('categories/{category}/image', [\App\Http\Controllers\Admin\CategoryController::class, 'deleteImage'])->name('categories.deleteImage');
    Route::post('categories/{category}/upload-hover-image', [\App\Http\Controllers\Admin\CategoryController::class, 'uploadHoverImage'])->name('categories.uploadHoverImage');
    Route::delete('categories/{category}/hover-image', [\App\Http\Controllers\Admin\CategoryController::class, 'deleteHoverImage'])->name('categories.deleteHoverImage');
    Route::post('categories/{category}/upload-banner-image', [\App\Http\Controllers\Admin\CategoryController::class, 'uploadBannerImage'])->name('categories.uploadBannerImage');
    Route::delete('categories/{category}/banner-image', [\App\Http\Controllers\Admin\CategoryController::class, 'deleteBannerImage'])->name('categories.deleteBannerImage');

    // AJAX Auto-save endpoints for Subcategories
    Route::patch('subcategories/{subcategory}/auto-save', [\App\Http\Controllers\Admin\SubcategoryController::class, 'autoSave'])->name('subcategories.autoSave');
    Route::post('subcategories/{subcategory}/upload-image', [\App\Http\Controllers\Admin\SubcategoryController::class, 'uploadImage'])->name('subcategories.uploadImage');
    Route::delete('subcategories/{subcategory}/image', [\App\Http\Controllers\Admin\SubcategoryController::class, 'deleteImage'])->name('subcategories.deleteImage');

    // AJAX Auto-save endpoints for Posts
    Route::patch('posts/{post}/auto-save', [\App\Http\Controllers\Admin\PostController::class, 'autoSave'])->name('posts.autoSave');
    Route::patch('posts/{post}/update-field', [\App\Http\Controllers\Admin\PostController::class, 'updateField'])->name('posts.updateField');
    Route::post('posts/{post}/upload-thumbnail', [\App\Http\Controllers\Admin\PostController::class, 'uploadThumbnail'])->name('posts.uploadThumbnail');
    Route::delete('posts/{post}/thumbnail', [\App\Http\Controllers\Admin\PostController::class, 'deleteThumbnail'])->name('posts.deleteThumbnail');

    // AJAX Auto-save endpoints for Pages
    Route::patch('pages/{page}/auto-save', [\App\Http\Controllers\Admin\PageController::class, 'autoSave'])->name('pages.autoSave');
    Route::patch('pages/{page}/update-field', [\App\Http\Controllers\Admin\PageController::class, 'updateField'])->name('pages.updateField');

    // AJAX Auto-save endpoints for Banners
    Route::patch('banners/{banner}/update-field', [\App\Http\Controllers\Admin\BannerController::class, 'updateField'])->name('banners.updateField');
    Route::post('banners/{banner}/upload-image', [\App\Http\Controllers\Admin\BannerController::class, 'uploadImage'])->name('banners.uploadImage');

    // AJAX Auto-save endpoints for Users
    Route::patch('users/{user}/update-field', [\App\Http\Controllers\Admin\UserController::class, 'updateField'])->name('users.updateField');

    // AJAX Auto-save endpoint for Settings
    Route::patch('settings/update-field', [\App\Http\Controllers\Admin\SettingController::class, 'updateField'])->name('settings.updateField');
    Route::post('settings/upload-logo', [\App\Http\Controllers\Admin\SettingController::class, 'uploadLogo'])->name('settings.uploadLogo');
    Route::post('settings/upload-banner/{key}', [\App\Http\Controllers\Admin\SettingController::class, 'uploadBanner'])->name('settings.uploadBanner');
    Route::delete('settings/logo', [\App\Http\Controllers\Admin\SettingController::class, 'deleteLogo'])->name('settings.deleteLogo');
    Route::delete('settings/banner/{key}', [\App\Http\Controllers\Admin\SettingController::class, 'deleteBanner'])
        ->where('key', '[a-z]+')
        ->name('settings.deleteBanner');

    // Mystery Box management
    Route::get('mystery-boxes', [\App\Http\Controllers\Admin\MysteryBoxController::class, 'index'])->name('mystery-boxes.index');
    Route::get('mystery-boxes/{mysteryBox}', [\App\Http\Controllers\Admin\MysteryBoxController::class, 'show'])->name('mystery-boxes.show');
    Route::patch('mystery-boxes/{mysteryBox}/status', [\App\Http\Controllers\Admin\MysteryBoxController::class, 'updateStatus'])->name('mystery-boxes.updateStatus');

    // VIP Levels management
    Route::resource('vip-levels', \App\Http\Controllers\Admin\VipLevelController::class);
    Route::post('vip-levels/{vipLevel}/products', [\App\Http\Controllers\Admin\VipLevelController::class, 'updateProducts'])->name('vip-levels.updateProducts');

    // Users VIP level assignment
    Route::post('users/{user}/vip-level', [\App\Http\Controllers\Admin\UserController::class, 'updateVipLevel'])->name('users.updateVipLevel');

    // Inquiries
    Route::get('inquiries', [\App\Http\Controllers\Admin\InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('inquiries/{inquiry}', [\App\Http\Controllers\Admin\InquiryController::class, 'show'])->name('inquiries.show');
    Route::patch('inquiries/{inquiry}/status', [\App\Http\Controllers\Admin\InquiryController::class, 'updateStatus'])->name('inquiries.updateStatus');

    // Settings (main routes)
    Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    // Chat management
    Route::get('chats', [\App\Http\Controllers\Admin\ChatController::class, 'index'])->name('chats.index');
    Route::get('chats/poll', [\App\Http\Controllers\Admin\ChatController::class, 'poll'])->name('chats.poll');
    Route::get('chats/unread-count', [\App\Http\Controllers\Admin\ChatController::class, 'unreadCount'])->name('chats.unreadCount');
    Route::post('chats/send', [\App\Http\Controllers\Admin\ChatController::class, 'store'])->name('chats.send');
    Route::post('chats/mark-as-read', [\App\Http\Controllers\Admin\ChatController::class, 'markAsRead'])->name('chats.markAsRead');
    Route::get('chats/{userId}', [\App\Http\Controllers\Admin\ChatController::class, 'show'])->name('chats.show');

});
