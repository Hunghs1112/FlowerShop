<?php
/**
 * Script to fix image storage structure:
 * 1. Move all images from public/images/* to storage/app/public/*
 * 2. Update database paths (strip 'images/' prefix)
 * 3. Keep banners in public/images/banners (special case)
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== FLOWER SHOP IMAGE PATH FIX ===\n\n";

// Paths
$publicImagesProducts = public_path('images/products');
$publicImagesCategories = public_path('images/categories');
$publicImagesBlog = public_path('images/blog');
$publicImagesDetail = public_path('images/detail');
$publicImagesInstagram = public_path('images/instagram');
$publicImagesMisc = public_path('images/misc');

$storageProducts = storage_path('app/public/products');
$storageCategories = storage_path('app/public/categories');
$storagePosts = storage_path('app/public/posts');

// 1. Move product images
echo "1. Moving product images...\n";
if (is_dir($publicImagesProducts)) {
    $files = glob($publicImagesProducts . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
    foreach ($files as $file) {
        $filename = basename($file);
        $dest = $storageProducts . '/' . $filename;
        if (!file_exists($dest)) {
            copy($file, $dest);
            echo "   Copied: $filename\n";
        }
    }
}

// 2. Move category images
echo "\n2. Moving category images...\n";
if (is_dir($publicImagesCategories)) {
    $files = glob($publicImagesCategories . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
    foreach ($files as $file) {
        $filename = basename($file);
        $dest = $storageCategories . '/' . $filename;
        if (!file_exists($dest)) {
            copy($file, $dest);
            echo "   Copied: $filename\n";
        }
    }
}

// 3. Move blog images
echo "\n3. Moving blog images...\n";
if (is_dir($publicImagesBlog)) {
    $files = glob($publicImagesBlog . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
    foreach ($files as $file) {
        $filename = basename($file);
        $dest = $storagePosts . '/' . $filename;
        if (!file_exists($dest)) {
            copy($file, $dest);
            echo "   Copied: $filename\n";
        }
    }
}

// 4. Update database - ProductImage table
echo "\n4. Updating product_media table...\n";
$updated = DB::table('product_media')
    ->where('image_path', 'like', 'images/products/%')
    ->update([
        'image_path' => DB::raw("REPLACE(image_path, 'images/products/', 'products/')")
    ]);
echo "   Updated $updated product media records\n";

// 5. Update database - Categories table
echo "\n5. Updating categories table...\n";
$updatedCat = DB::table('categories')
    ->where('image', 'like', 'images/categories/%')
    ->update([
        'image' => DB::raw("REPLACE(image, 'images/categories/', 'categories/')")
    ]);
echo "   Updated $updatedCat category image records\n";

$updatedCatHover = DB::table('categories')
    ->where('hover_image', 'like', 'images/categories/%')
    ->update([
        'hover_image' => DB::raw("REPLACE(hover_image, 'images/categories/', 'categories/')")
    ]);
echo "   Updated $updatedCatHover category hover_image records\n";

// 6. Update database - Subcategories table (if exists)
echo "\n6. Updating subcategories table...\n";
try {
    $updatedSub = DB::table('subcategories')
        ->where('image', 'like', 'images/categories/%')
        ->update([
            'image' => DB::raw("REPLACE(image, 'images/categories/', 'categories/')")
        ]);
    echo "   Updated $updatedSub subcategory records\n";
} catch (Exception $e) {
    echo "   (Subcategories table not found or no updates needed)\n";
}

// 7. Update database - Posts table
echo "\n7. Updating posts table...\n";
try {
    $updatedPosts = DB::table('posts')
        ->where('thumbnail', 'like', 'images/%')
        ->where('thumbnail', 'not like', 'images/banners/%')
        ->update([
            'thumbnail' => DB::raw("REPLACE(thumbnail, 'images/', '')")
        ]);
    echo "   Updated $updatedPosts post records\n";
} catch (Exception $e) {
    echo "   (Posts table not found or no updates needed)\n";
}

// 8. Clean up duplicate images in storage/app/public/images/products/
echo "\n8. Removing duplicate images from storage/app/public/images/products/...\n";
$storageImagesProducts = storage_path('app/public/images/products');
if (is_dir($storageImagesProducts)) {
    $files = glob($storageImagesProducts . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
            echo "   Deleted: " . basename($file) . "\n";
        }
    }
    if (count(scandir($storageImagesProducts)) == 2) { // only . and ..
        rmdir($storageImagesProducts);
        echo "   Removed empty directory: images/products\n";
    }
}

echo "\n=== DONE ===\n";
echo "Images moved to storage/app/public/\n";
echo "Database paths updated\n";
echo "Banners remain in public/images/banners/\n";
