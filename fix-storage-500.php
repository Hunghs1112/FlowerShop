#!/usr/bin/env php
<?php
/**
 * Script FIX LỖI 500 sau khi tạo storage symlink
 * 
 * Vấn đề: Script V2 đã đổi tên toàn bộ folder storage/ thành storage_backup/
 * nhưng Laravel cần storage/framework/, storage/logs/ để hoạt động!
 * 
 * Giải pháp: Tạo lại cấu trúc storage với symlink chỉ cho app/public
 */

echo "=== FIX STORAGE STRUCTURE ===\n\n";

$publicHtml = __DIR__;
$storageLink = $publicHtml . '/storage';
$backupDir = null;

// 1. Tìm thư mục backup
$items = scandir($publicHtml);
foreach ($items as $item) {
    if (strpos($item, 'storage_backup_') === 0) {
        $backupDir = $publicHtml . '/' . $item;
        break;
    }
}

if (!$backupDir || !is_dir($backupDir)) {
    echo "❌ Không tìm thấy folder backup!\n\n";
    exit(1);
}

echo "Found backup: " . basename($backupDir) . "\n";

// 2. Xóa symlink hiện tại (sai cấu trúc)
if (is_link($storageLink)) {
    echo "Removing incorrect symlink...\n";
    unlink($storageLink);
    echo "   ✅ Removed\n\n";
}

// 3. Restore toàn bộ folder storage từ backup
echo "Restoring full storage structure...\n";
if (rename($backupDir, $storageLink)) {
    echo "   ✅ Restored: storage/\n\n";
} else {
    echo "   ❌ Failed to restore!\n\n";
    exit(1);
}

// 4. Bây giờ tạo symlink TRONG public/ (không phải thay thế storage/)
$publicDir = $publicHtml . '/public';
$publicStorageLink = $publicDir . '/storage';
$targetDir = $publicHtml . '/storage/app/public';

// Check if public/ exists (nếu dùng cấu trúc Laravel chuẩn)
if (is_dir($publicDir)) {
    echo "Found public/ directory - using standard Laravel structure\n";
    
    // Remove old link/folder in public/storage if exists
    if (file_exists($publicStorageLink)) {
        if (is_link($publicStorageLink)) {
            unlink($publicStorageLink);
        } elseif (is_dir($publicStorageLink)) {
            // Don't auto-delete directory, too dangerous
            echo "⚠️  public/storage/ exists as directory!\n";
            echo "   Please manually rename it, then run this script again.\n\n";
            exit(1);
        }
    }
    
    // Create symlink in public/
    if (symlink($targetDir, $publicStorageLink)) {
        echo "   ✅ Created: public/storage -> storage/app/public\n\n";
    } else {
        echo "   ❌ Failed to create symlink in public/\n\n";
        exit(1);
    }
} else {
    // Không có public/ = đang dùng cấu trúc public_html root
    echo "No public/ folder - you're using public_html root structure\n";
    echo "Creating symlink directly in root...\n";
    
    $rootStorageLink = $publicHtml . '/storage_public';
    
    if (symlink($targetDir, $rootStorageLink)) {
        echo "   ✅ Created: storage_public -> storage/app/public\n";
        echo "\n⚠️  IMPORTANT: Update .htaccess to rewrite /storage/ to /storage_public/\n";
        echo "   Or rename storage_public to something accessible.\n\n";
    }
}

echo "✅ DONE! Structure should be:\n";
echo "   storage/                 [REAL FOLDER]\n";
echo "   ├── app/\n";
echo "   │   └── public/          [FILES HERE]\n";
echo "   ├── framework/\n";
echo "   └── logs/\n";
echo "   public/storage/          [SYMLINK] -> storage/app/public\n\n";
echo "Test your site now!\n\n";
