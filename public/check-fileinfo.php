<?php
// File kiểm tra fileinfo extension chi tiết

echo "=== FILEINFO EXTENSION CHECK ===\n\n";

echo "PHP Version: " . PHP_VERSION . "\n\n";

// Check fileinfo
if (extension_loaded('fileinfo')) {
    echo "✅ fileinfo extension: LOADED\n\n";
    
    // Test fileinfo hoạt động
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    echo "✅ finfo object created successfully\n";
    echo "Test MIME detection: " . $finfo->file(__FILE__) . "\n\n";
} else {
    echo "❌ fileinfo extension: NOT LOADED\n\n";
    echo "SOLUTIONS:\n";
    echo "1. cPanel → Select PHP Version → Extensions → Check 'fileinfo'\n";
    echo "2. Or add to .user.ini: extension=fileinfo\n";
    echo "3. Contact hosting provider if not available\n\n";
}

// List all loaded extensions
echo "=== ALL LOADED EXTENSIONS ===\n";
$extensions = get_loaded_extensions();
sort($extensions);
foreach ($extensions as $ext) {
    echo "- $ext\n";
}

echo "\n=== PHP INFO (fileinfo section) ===\n";
ob_start();
phpinfo(INFO_MODULES);
$info = ob_get_clean();
if (stripos($info, 'fileinfo') !== false) {
    echo "Found in phpinfo()\n";
} else {
    echo "NOT found in phpinfo()\n";
}
