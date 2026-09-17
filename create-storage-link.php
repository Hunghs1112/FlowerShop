#!/usr/bin/env php
<?php
/**
 * Script tạo symbolic link từ public/storage → storage/app/public
 * Chạy trên cPanel hosting thông qua Terminal hoặc SSH
 * 
 * Upload file này lên public_html/ và chạy: php create-storage-link.php
 */

// Đường dẫn absolute trên server
$targetDir = __DIR__ . '/storage/app/public';  // Target: storage/app/public
$linkPath = __DIR__ . '/storage';              // Link: public/storage

echo "=== LARAVEL STORAGE LINK CREATOR ===\n\n";
echo "Current directory: " . __DIR__ . "\n";
echo "Target directory: $targetDir\n";
echo "Link path: $linkPath\n\n";

// Check if target exists
if (!is_dir($targetDir)) {
    echo "❌ ERROR: storage/app/public directory not found!\n";
    echo "   Please create it first or upload storage folder.\n\n";
    exit(1);
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
        echo "❌ ERROR: 'storage' exists as a directory!\n";
        echo "   Please rename/remove it first.\n\n";
        exit(1);
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
    
    // Create subdirectories if needed
    $subdirs = ['categories', 'products', 'images'];
    foreach ($subdirs as $dir) {
        $path = $targetDir . '/' . $dir;
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
            echo "✅ Created: storage/app/public/$dir\n";
        }
    }
    
    exit(0);
} else {
    echo "❌ ERROR: Failed to create symbolic link!\n\n";
    echo "Possible solutions:\n";
    echo "1. Check if your hosting allows symlink() function\n";
    echo "2. Use cPanel File Manager: Right-click storage/app/public → Create Link\n";
    echo "3. Contact hosting support to enable symlink\n\n";
    exit(1);
}
