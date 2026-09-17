#!/usr/bin/env php
<?php
/**
 * SCRIPT KHẮC PHỤC HOÀN CHỈNH - LỖI 404 ẢNH
 * 
 * Vấn đề: Sau khi chạy create-storage-link-v2.php, folder storage/ bị đổi tên
 * thành storage_backup_xxx, dẫn đến:
 * 1. Laravel bị lỗi 500 (thiếu storage/framework, storage/logs)
 * 2. Ảnh bị lỗi 404 (không tìm thấy storage/app/public)
 * 
 * Script này sẽ:
 * 1. Restore lại folder storage/ từ backup
 * 2. Tạo cấu trúc đúng cho Laravel trên public_html root
 * 3. Hướng dẫn config .htaccess để ảnh hoạt động
 */

echo "=== FIX TOÀN BỘ VẤN ĐỀ STORAGE ===\n\n";

$root = __DIR__;
$storageDir = $root . '/storage';
$backupDir = null;

// 1. Tìm thư mục backup
echo "Bước 1: Tìm thư mục backup...\n";
$items = scandir($root);
foreach ($items as $item) {
    if (strpos($item, 'storage_backup_') === 0 && is_dir($root . '/' . $item)) {
        $backupDir = $root . '/' . $item;
        echo "   ✅ Tìm thấy: $item\n\n";
        break;
    }
}

// 2. Restore storage nếu cần
if ($backupDir && !is_dir($storageDir)) {
    echo "Bước 2: Restore folder storage/...\n";
    if (rename($backupDir, $storageDir)) {
        echo "   ✅ Đã restore storage/\n\n";
    } else {
        echo "   ❌ Không thể restore!\n";
        echo "   → Làm thủ công: Rename '$backupDir' thành 'storage'\n\n";
        exit(1);
    }
} elseif (is_link($storageDir)) {
    // Storage là symlink (SAI!)
    echo "Bước 2: Xóa symlink sai...\n";
    unlink($storageDir);
    
    if ($backupDir) {
        echo "   Restore từ backup...\n";
        if (rename($backupDir, $storageDir)) {
            echo "   ✅ Đã restore storage/\n\n";
        } else {
            echo "   ❌ Không thể restore!\n\n";
            exit(1);
        }
    } else {
        echo "   ❌ Không tìm thấy backup!\n";
        echo "   → Tạo lại cấu trúc storage thủ công\n\n";
        exit(1);
    }
} elseif (is_dir($storageDir)) {
    echo "Bước 2: Folder storage/ đã tồn tại ✅\n\n";
}

// 3. Kiểm tra cấu trúc storage/app/public
echo "Bước 3: Kiểm tra storage/app/public/...\n";
$storagePublic = $storageDir . '/app/public';

if (!is_dir($storagePublic)) {
    echo "   ⚠️  Không tồn tại, tạo mới...\n";
    mkdir($storagePublic, 0755, true);
}

$subdirs = ['categories', 'products', 'images'];
foreach ($subdirs as $dir) {
    $path = $storagePublic . '/' . $dir;
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
        echo "   ✅ Tạo: $dir/\n";
    } else {
        $count = count(glob($path . '/*'));
        echo "   ✅ $dir/ ($count files)\n";
    }
}
echo "\n";

// 4. Xử lý symlink hoặc .htaccess rewrite
echo "Bước 4: Thiết lập truy cập ảnh...\n";

// Kiểm tra có folder public/ không (Laravel chuẩn vs public_html root)
$publicDir = $root . '/public';

if (is_dir($publicDir)) {
    // Laravel structure chuẩn
    echo "   Phát hiện: Cấu trúc Laravel chuẩn (có public/)\n";
    $publicStorage = $publicDir . '/storage';
    
    if (file_exists($publicStorage)) {
        if (is_link($publicStorage)) {
            echo "   ✅ Symlink public/storage đã tồn tại\n\n";
        } else {
            echo "   ⚠️  public/storage là folder, cần đổi thành symlink\n";
            echo "   → Chạy: php artisan storage:link\n\n";
        }
    } else {
        // Tạo symlink
        if (symlink($storagePublic, $publicStorage)) {
            echo "   ✅ Tạo symlink: public/storage → storage/app/public\n\n";
        } else {
            echo "   ❌ Không thể tạo symlink!\n";
            echo "   → Chạy thủ công: php artisan storage:link\n\n";
        }
    }
} else {
    // public_html root structure
    echo "   Phát hiện: Cấu trúc public_html root (không có public/)\n";
    echo "   → Không thể dùng symlink, cần dùng .htaccess rewrite\n\n";
    
    echo "📝 THÊM VÀO FILE .htaccess:\n\n";
    echo "   # Rewrite /storage/ requests to storage/app/public/\n";
    echo "   RewriteCond %{REQUEST_URI} ^/storage/(.+)$\n";
    echo "   RewriteCond %{DOCUMENT_ROOT}/storage/app/public/%1 -f\n";
    echo "   RewriteRule ^storage/(.+)$ storage/app/public/$1 [L]\n\n";
}

// 5. Test permissions
echo "Bước 5: Kiểm tra permissions...\n";
$testPerms = [
    $storageDir => '755',
    $storagePublic => '755',
];

foreach ($testPerms as $path => $expected) {
    $perms = substr(sprintf('%o', fileperms($path)), -3);
    if ($perms >= $expected) {
        echo "   ✅ " . basename($path) . "/ ($perms)\n";
    } else {
        echo "   ⚠️  " . basename($path) . "/ ($perms) → nên là $expected\n";
    }
}

echo "\n";
echo "=== HOÀN TẤT ===\n\n";
echo "✅ Cấu trúc storage đã được khôi phục!\n";
echo "✅ Code frontend đã được fix (dùng image_url accessor)\n\n";
echo "📋 KIỂM TRA TIẾP:\n";
echo "1. Upload code mới lên server (3 view files đã fix)\n";
echo "2. Nếu dùng public_html root: cập nhật .htaccess\n";
echo "3. Clear cache: php artisan cache:clear\n";
echo "4. Test upload ảnh mới trong admin\n";
echo "5. Kiểm tra ảnh hiển thị trên frontend\n\n";
echo "⚠️  XÓA SCRIPT NÀY sau khi hoàn tất!\n\n";
