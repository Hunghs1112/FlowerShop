#!/usr/bin/env php
<?php
/**
 * Script khôi phục cấu trúc storage sau khi tạo symlink
 * Chạy ngay sau khi tạo symlink để tránh lỗi 500
 */

$publicHtml = __DIR__;
$backupDir = null;

echo "=== LARAVEL STORAGE RECOVERY ===\n\n";

// Find backup folder
$items = scandir($publicHtml);
foreach ($items as $item) {
    if (strpos($item, 'storage_backup_') === 0) {
        $backupDir = $publicHtml . '/' . $item;
        break;
    }
}

if (!$backupDir || !is_dir($backupDir)) {
    echo "❌ No backup folder found!\n";
    echo "   Looking for: storage_backup_XXXXXXX\n\n";
    exit(1);
}

echo "Found backup: " . basename($backupDir) . "\n\n";

// Copy framework folders back
$frameworkDirs = ['framework', 'logs', 'app'];

foreach ($frameworkDirs as $dir) {
    $source = $backupDir . '/' . $dir;
    $dest = $publicHtml . '/' . $dir;
    
    if (is_dir($source)) {
        echo "Copying $dir...\n";
        
        // Recursive copy function
        if (copyDir($source, $dest)) {
            echo "   ✅ Copied: $dir\n";
        } else {
            echo "   ❌ Failed: $dir\n";
        }
    }
}

echo "\n✅ Storage structure recovered!\n";
echo "⚠️  Keep backup folder for safety: " . basename($backupDir) . "\n\n";

function copyDir($src, $dst) {
    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
    }
    
    $dir = opendir($src);
    if (!$dir) return false;
    
    while (($file = readdir($dir)) !== false) {
        if ($file != '.' && $file != '..') {
            $srcPath = $src . '/' . $file;
            $dstPath = $dst . '/' . $file;
            
            if (is_dir($srcPath)) {
                copyDir($srcPath, $dstPath);
            } else {
                copy($srcPath, $dstPath);
            }
        }
    }
    
    closedir($dir);
    return true;
}
