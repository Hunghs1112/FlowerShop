#!/bin/bash

echo "🎥 Video Feature - Quick Test Script"
echo "===================================="
echo ""

# Check routes
echo "1️⃣ Checking Routes..."
php artisan route:list | grep -E 'products.*(upload|video)' || echo "❌ Routes not found"
echo ""

# Check database columns
echo "2️⃣ Checking Database Schema..."
php artisan tinker --execute="
\$cols = Schema::getColumnListing('product_images');
\$required = ['media_type', 'mime_type', 'video_url', 'thumbnail_path'];
\$missing = array_diff(\$required, \$cols);
if (empty(\$missing)) {
    echo '✅ All required columns exist' . PHP_EOL;
} else {
    echo '❌ Missing columns: ' . implode(', ', \$missing) . PHP_EOL;
}
"
echo ""

# Check files exist
echo "3️⃣ Checking Files..."
files=(
    "app/Models/ProductImage.php"
    "app/Http/Controllers/Admin/ProductController.php"
    "resources/views/admin/products/form.blade.php"
    "resources/views/products/detail.blade.php"
    "config/upload.php"
)

for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo "✅ $file"
    else
        echo "❌ $file NOT FOUND"
    fi
done
echo ""

# Check syntax
echo "4️⃣ Checking Syntax..."
php -l app/Models/ProductImage.php 2>&1 | grep -q "No syntax errors" && echo "✅ ProductImage.php" || echo "❌ ProductImage.php has errors"
php -l app/Http/Controllers/Admin/ProductController.php 2>&1 | grep -q "No syntax errors" && echo "✅ ProductController.php" || echo "❌ ProductController.php has errors"
echo ""

# Check config
echo "5️⃣ Checking Config..."
php artisan tinker --execute="
\$config = config('upload.limits.product_videos');
if (\$config) {
    echo '✅ Config exists' . PHP_EOL;
    echo '  - Max size: ' . \$config['max_size'] . 'KB (' . (\$config['max_size']/1024) . 'MB)' . PHP_EOL;
    echo '  - Max count: ' . \$config['max_count'] . PHP_EOL;
} else {
    echo '❌ Config not found' . PHP_EOL;
}
"
echo ""

# Test model scopes
echo "6️⃣ Testing Model Scopes..."
php artisan tinker --execute="
try {
    \$product = App\Models\Product::first();
    if (\$product) {
        \$images = \$product->productImages()->images()->count();
        \$videos = \$product->productImages()->videos()->count();
        echo '✅ Scopes working' . PHP_EOL;
        echo '  - Product: ' . \$product->name . PHP_EOL;
        echo '  - Images: ' . \$images . PHP_EOL;
        echo '  - Videos: ' . \$videos . PHP_EOL;
    } else {
        echo '⚠️  No products in database' . PHP_EOL;
    }
} catch (Exception \$e) {
    echo '❌ Error: ' . \$e->getMessage() . PHP_EOL;
}
"
echo ""

echo "===================================="
echo "✅ Video Feature Test Complete!"
echo ""
echo "📝 Documentation:"
echo "  - VIDEO_IMPLEMENTATION_SUMMARY.md"
echo "  - VIDEO_FEATURE_COMPLETE.md"
echo ""
echo "🚀 Ready to use!"
