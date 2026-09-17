<?php
echo "PHP Version: " . PHP_VERSION . "\n";
echo "\n";
echo "Required: PHP 8.2+\n";
echo "\n";

if (version_compare(PHP_VERSION, '8.2.0', '>=')) {
    echo "✅ PHP version OK!\n";
} else {
    echo "❌ PHP version TOO OLD! Please upgrade to PHP 8.2+\n";
}

echo "\n--- Extensions Check ---\n";
$required = ['pdo', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'fileinfo', 'curl'];
foreach ($required as $ext) {
    $loaded = extension_loaded($ext);
    echo ($loaded ? '✅' : '❌') . " $ext\n";
}
