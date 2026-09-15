<?php

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
Route::post('/lien-he', [PageController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/trang/{slug}', [PageController::class, 'policy'])->name('policy');

// Cart
Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
Route::post('/gio-hang/them', [CartController::class, 'add'])->name('cart.add');
Route::patch('/gio-hang/{cartItem}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/gio-hang/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::delete('/gio-hang', [CartController::class, 'clear'])->name('cart.clear');

// Quick order
Route::post('/dat-hang-nhanh', [QuickOrderController::class, 'store'])->name('quick-order.store');

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
    Route::get('/thanh-toan/thanh-cong', [CheckoutController::class, 'success'])->name('checkout.success');

    // Profile
    Route::get('/tai-khoan', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/tai-khoan', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/tai-khoan/mat-khau', [ProfileController::class, 'updatePassword'])->name('profile.password');
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

    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

    Route::get('inquiries', [\App\Http\Controllers\Admin\InquiryController::class, 'index'])->name('inquiries.index');
    Route::get('inquiries/{inquiry}', [\App\Http\Controllers\Admin\InquiryController::class, 'show'])->name('inquiries.show');
    Route::patch('inquiries/{inquiry}/status', [\App\Http\Controllers\Admin\InquiryController::class, 'updateStatus'])->name('inquiries.updateStatus');

    Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
});
