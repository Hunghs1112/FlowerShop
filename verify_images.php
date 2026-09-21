<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== IMAGE PATH VERIFICATION ===\n\n";

// 1. Check product images
echo "1. Product Images:\n";
$products = App\Models\Product::with('productImages')->take(3)->get();
foreach ($products as $product) {
    echo "   Product: {$product->name}\n";
    foreach ($product->productImages as $img) {
        $path = storage_path('app/public/' . $img->image_path);
        $exists = file_exists($path) ? '✓' : '✗';
        echo "      {$exists} {$img->image_path}\n";
        echo "         URL: {$img->image_url}\n";
    }
}

// 2. Check categories
echo "\n2. Categories:\n";
$categories = App\Models\Category::whereNotNull('image')->where('image', '!=', '')->take(3)->get();
foreach ($categories as $cat) {
    $path = storage_path('app/public/' . $cat->image);
    $exists = file_exists($path) ? '✓' : '✗';
    echo "   {$exists} {$cat->name}: {$cat->image}\n";
    echo "      URL: {$cat->image_url}\n";
}

// 3. Check banners (special case - in public/images/banners)
echo "\n3. Banners:\n";
$banners = DB::table('settings')->where('key', 'like', 'banner_%')->get();
foreach ($banners as $banner) {
    $path = public_path($banner->value);
    $exists = file_exists($path) ? '✓' : '✗';
    echo "   {$exists} {$banner->key}: {$banner->value}\n";
}

echo "\n=== VERIFICATION COMPLETE ===\n";
