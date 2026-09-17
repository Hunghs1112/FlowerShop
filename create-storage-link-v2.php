#!/usr/bin/env php
<?php
/**
 * Script tạo symbolic link từ public/storage → storage/app/public
 * Version 2: Tự động backup thư mục storage cũ nếu tồn tại
 */

$targetDir = __DIR__ . '/storage/app/public';  // Target: storage/app/public
$linkPath = __DIR__ . '/storage';              // Link: public/storage (trong public_html)

echo "=== LARAVEL STORAGE LINK CREATOR V2 ===\n\n";
echo "Current directory: " . __DIR__ . "\n";
echo "Target directory: $targetDir\n";
echo "Link path: $linkPath\n\n";

// Check if target exists
if (!is_dir($targetDir)) {
    echo "❌ ERROR: storage/app/public directory not found!\n";
    echo "   Creating it now...\n";
    mkdir($targetDir, 0755, true);
    
    // Create subdirectories
    $subdirs = ['categories', 'products', 'images'];
    foreach ($subdirs as $dir) {
        $path = $targetDir . '/' . $dir;
        mkdir($path, 0755, true);
        echo "   ✅ Created: storage/app/public/$dir\n";
    }
    echo "\n";
}

// Check if link already exists
if (file_exists($linkPath)) {
    if (is_link($linkPath)) {
        $current = readlink($linkPath);
        if ($current === $targetDir) {
            echo "✅ Symbolic link already exists and points to correct location.\n";
            echo "   Link: $linkPath -> $targetDir\n\n";
            exit(0);
        } else {
            echo "⚠️  Link exists but points to: $current\n";
            echo "   Removing old link...\n";
            unlink($linkPath);
        }
    } elseif (is_dir($linkPath)) {
        // Backup existing storage directory
        $backupPath = __DIR__ . '/storage_backup_' . time();
        echo "⚠️  'storage' exists as a directory!\n";
        echo "   Renaming to: " . basename($backupPath) . "\n";
        
        if (rename($linkPath, $backupPath)) {
            echo "   ✅ Backup created successfully.\n\n";
        } else {
            echo "   ❌ Failed to rename. Please manually rename 'storage' folder.\n\n";
            exit(1);
        }
    }
}

// Create symbolic link
echo "Creating symbolic link...\n";

if (symlink($targetDir, $linkPath)) {
    echo "✅ SUCCESS! Symbolic link created.\n\n";
    echo "   Link: $linkPath\n";
    echo "   Target: $targetDir\n\n";
    echo "Now your images should be accessible at:\n";
    echo "   http://yourdomain.com/storage/categories/image.jpg\n\n";
    
    // List what's inside
    echo "Files in storage/app/public/:\n";
    $items = scandir($targetDir);
    foreach ($items as $item) {
        if ($item !== '.' && $item !== '..') {
            $itemPath = $targetDir . '/' . $item;
            $type = is_dir($itemPath) ? '[DIR]' : '[FILE]';
            echo "   $type $item\n";
        }
    }
    
    echo "\n✅ Done! You can now upload images.\n";
    echo "⚠️  Remember to DELETE this script after testing!\n\n";
    exit(0);
} else {
    echo "❌ ERROR: Failed to create symbolic link!\n\n";
    echo "Possible solutions:\n";
    echo "1. Your hosting may not allow symlink() function\n";
    echo "2. Contact hosting support to enable symlink\n";
    echo "3. Use alternative: Move files directly to public/storage/\n\n";
    exit(1);
}
