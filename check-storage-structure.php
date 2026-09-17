#!/usr/bin/env php
<?php
/**
 * SCRIPT KIỂM TRA & HƯỚNG DẪN FIX LỖI 404 ẢNH
 * 
 * Chạy script này để kiểm tra:
 * 1. Symbolic link có tồn tại không
 * 2. Các thư mục storage có đúng cấu trúc không
 * 3. File ảnh có tồn tại không
 */

echo "=== KIỂM TRA CẤU TRÚC STORAGE ===\n\n";

$publicHtml = __DIR__;
$checks = [];

// 1. Check storage directory structure
echo "1️⃣ Kiểm tra thư mục storage/\n";
$storagePath = $publicHtml . '/storage';

if (!file_exists($storagePath)) {
    $checks[] = "❌ Folder 'storage/' không tồn tại!";
    echo "   ❌ KHÔNG TỒN TẠI\n\n";
} elseif (is_link($storagePath)) {
    $target = readlink($storagePath);
    $checks[] = "⚠️  'storage/' là symlink → $target (SAI!)";
    echo "   ⚠️  Là SYMLINK → $target\n";
    echo "   ❌ KHÔNG ĐÚNG! storage/ phải là thư mục thật.\n\n";
} elseif (is_dir($storagePath)) {
    echo "   ✅ Là thư mục thật (ĐÚNG)\n\n";
}

// 2. Check storage/app/public
echo "2️⃣ Kiểm tra storage/app/public/\n";
$storagePublic = $publicHtml . '/storage/app/public';

if (!is_dir($storagePublic)) {
    $checks[] = "❌ Folder 'storage/app/public/' không tồn tại!";
    echo "   ❌ KHÔNG TỒN TẠI\n\n";
} else {
    echo "   ✅ Tồn tại\n";
    
    // List subdirectories
    $subdirs = ['categories', 'products', 'images'];
    foreach ($subdirs as $dir) {
        $path = $storagePublic . '/' . $dir;
        if (is_dir($path)) {
            $count = count(glob($path . '/*'));
            echo "   ✅ $dir/ ($count files)\n";
        } else {
            echo "   ⚠️  $dir/ không tồn tại\n";
            $checks[] = "⚠️  Thiếu folder storage/app/public/$dir/";
        }
    }
    echo "\n";
}

// 3. Check public/storage symlink (for standard Laravel structure)
echo "3️⃣ Kiểm tra public/storage symlink\n";
$publicDir = $publicHtml . '/public';
$publicStorage = $publicDir . '/storage';

if (!is_dir($publicDir)) {
    echo "   ⚠️  Không có folder public/ (đang dùng public_html root)\n";
    echo "   → Cần tạo symlink trực tiếp trong root\n\n";
    $checks[] = "⚠️  Cấu trúc public_html root - cần giải pháp khác";
} else {
    if (!file_exists($publicStorage)) {
        echo "   ❌ public/storage KHÔNG TỒN TẠI\n";
        $checks[] = "❌ Chưa tạo symlink public/storage → storage/app/public";
    } elseif (is_link($publicStorage)) {
        $target = readlink($publicStorage);
        if (realpath($target) === realpath($storagePublic)) {
            echo "   ✅ Symlink ĐÚNG → $target\n";
        } else {
            echo "   ⚠️  Symlink sai → $target\n";
            $checks[] = "⚠️  Symlink trỏ sai vị trí";
        }
    } elseif (is_dir($publicStorage)) {
        echo "   ❌ public/storage là THƯ MỤC (phải là symlink)\n";
        $checks[] = "❌ public/storage phải là symlink, không phải folder";
    }
    echo "\n";
}

// 4. Test file access
echo "4️⃣ Kiểm tra file ảnh mẫu\n";
$testFiles = [
    'categories/1789632731-MUojk9fN.jpg',
    'products/1789632686-cWVsydIr.png'
];

foreach ($testFiles as $file) {
    $fullPath = $storagePublic . '/' . $file;
    if (file_exists($fullPath)) {
        echo "   ✅ $file (tồn tại)\n";
    } else {
        echo "   ❌ $file (không tìm thấy)\n";
        $checks[] = "❌ File không tồn tại: $file";
    }
}

echo "\n";
echo "=== KẾT QUẢ ===\n\n";

if (empty($checks)) {
    echo "✅ TẤT CẢ KIỂM TRA ĐỀU PASS!\n";
    echo "   Nếu vẫn lỗi 404, kiểm tra:\n";
    echo "   - Clear cache: php artisan cache:clear\n";
    echo "   - Kiểm tra .htaccess\n";
    echo "   - Kiểm tra permissions (755 cho folders, 644 cho files)\n\n";
} else {
    echo "⚠️  PHÁT HIỆN VẤN ĐỀ:\n\n";
    foreach ($checks as $check) {
        echo "   $check\n";
    }
    echo "\n";
    echo "📋 HƯỚNG DẪN FIX:\n\n";
    
    if (in_array("❌ Chưa tạo symlink public/storage → storage/app/public", $checks)) {
        echo "✅ Tạo symlink:\n";
        echo "   cd public_html\n";
        echo "   php artisan storage:link\n\n";
        echo "   Hoặc thủ công:\n";
        echo "   ln -s ../storage/app/public public/storage\n\n";
    }
    
    if (strpos(implode('', $checks), 'public_html root') !== false) {
        echo "✅ Với cấu trúc public_html root:\n";
        echo "   Sửa file .htaccess thêm:\n";
        echo "   RewriteRule ^storage/(.*)$ storage/app/public/$1 [L]\n\n";
    }
}

echo "Upload code mới lên server và test lại!\n\n";
