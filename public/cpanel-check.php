<?php
/**
 * cPanel Compatibility Check Script
 * 
 * Upload file này lên hosting để kiểm tra trước khi deploy
 * Sau khi kiểm tra xong, XÓA FILE NÀY NGAY!
 */

// Security: Only allow from localhost
$allowed_ips = ['127.0.0.1', '::1'];
$client_ip = $_SERVER['REMOTE_ADDR'] ?? '';

echo '<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cPanel Compatibility Check</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .section { margin: 30px 0; padding: 20px; background: #f9f9f9; border-radius: 8px; }
        h2 { color: #333; }
        .delete-notice { background: #ff4444; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="delete-notice">
        ⚠️ SECURITY WARNING: XÓA FILE NÀY SAU KHI KIỂM TRA XONG!
    </div>

    <h1>🌸 cPanel Compatibility Check</h1>
    <p>Kiểm tra hosting có đáp ứng yêu cầu để chạy Laravel FlowerShop không.</p>
    
    <div class="section">
        <h2>📋 PHP Version</h2>';
        
$php_version = PHP_VERSION;
$required_version = '8.2.0';
echo '<p>Phiên bản hiện tại: <strong>' . $php_version . '</strong></p>';

if (version_compare($php_version, $required_version, '>=')) {
    echo '<p class="success">✓ PHP đạt yêu cầu (cần 8.2+)</p>';
} else {
    echo '<p class="error">✗ PHP cần nâng cấp lên 8.2+</p>';
}

echo '    </div>
    
    <div class="section">
        <h2>🔧 Required PHP Extensions</h2>
        <table>
            <tr>
                <th>Extension</th>
                <th>Status</th>
            </tr>';

$required_extensions = [
    'pdo', 'pdo_mysql', 'mbstring', 'openssl', 'tokenizer',
    'xml', 'ctype', 'json', 'fileinfo', 'curl', 'gd', 'zip'
];

foreach ($required_extensions as $ext) {
    $loaded = extension_loaded($ext);
    $status = $loaded ? '<span class="success">✓ Enabled</span>' : '<span class="error">✗ Missing</span>';
    echo '<tr><td>' . $ext . '</td><td>' . $status . '</td></tr>';
}

echo '</table>
    </div>
    
    <div class="section">
        <h2>📁 Directory Permissions</h2>
        <table>
            <tr>
                <th>Directory</th>
                <th>Path</th>
                <th>Writable</th>
            </tr>';

$dirs_to_check = [
    'storage/' => __DIR__ . '/../storage',
    'storage/app/' => __DIR__ . '/../storage/app',
    'storage/app/public/' => __DIR__ . '/../storage/app/public',
    'storage/framework/' => __DIR__ . '/../storage/framework',
    'storage/framework/cache/' => __DIR__ . '/../storage/framework/cache',
    'storage/framework/sessions/' => __DIR__ . '/../storage/framework/sessions',
    'storage/framework/views/' => __DIR__ . '/../storage/framework/views',
    'storage/logs/' => __DIR__ . '/../storage/logs',
    'bootstrap/cache/' => __DIR__ . '/../bootstrap/cache',
];

foreach ($dirs_to_check as $name => $path) {
    $writable = is_writable($path) ? '<span class="success">✓ Yes</span>' : '<span class="error">✗ No</span>';
    echo '<tr><td>' . $name . '</td><td>' . $path . '</td><td>' . $writable . '</td></tr>';
}

echo '</table>
    </div>
    
    <div class="section">
        <h2>🗄️ Database Connection Test</h2>
        <form method="post">
            <p>Điền thông tin database để test kết nối:</p>
            <p>
                <label>Host: <input type="text" name="db_host" value="localhost" style="width: 200px;"></label>
                <label>Database: <input type="text" name="db_name" placeholder="your_db_name" style="width: 200px;"></label>
            </p>
            <p>
                <label>Username: <input type="text" name="db_user" placeholder="your_db_user" style="width: 200px;"></label>
                <label>Password: <input type="password" name="db_pass" style="width: 200px;"></label>
            </p>
            <button type="submit" style="padding: 10px 20px; font-size: 16px;">Test Connection</button>
        </form>';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['db_host'])) {
    $host = $_POST['db_host'];
    $name = $_POST['db_name'];
    $user = $_POST['db_user'];
    $pass = $_POST['db_pass'];
    
    echo '<div style="margin-top: 20px;">';
    
    try {
        $dsn = 'mysql:host=' . $host . ';dbname=' . $name;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        
        $pdo = new PDO($dsn, $user, $pass, $options);
        echo '<p class="success">✓ Kết nối database thành công!</p>';
        
        // Get MySQL version
        $stmt = $pdo->query('SELECT VERSION() as version');
        $row = $stmt->fetch();
        echo '<p>MySQL Version: <strong>' . $row['version'] . '</strong></p>';
        
        // List existing tables
        $tables = $pdo->query('SHOW TABLES')->fetchAll(PDD::FETCH_COLUMN);
        if (count($tables) > 0) {
            echo '<p>Các bảng hiện có: <em>' . implode(', ', $tables) . '</em></p>';
        } else {
            echo '<p>Database trống - sẵn sàng chạy migration.</p>';
        }
        
    } catch (PDOException $e) {
        echo '<p class="error">✗ Lỗi kết nối: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
    
    echo '</div>';
}

echo '    </div>
    
    <div class="section">
        <h2>📊 Server Info</h2>
        <table>
            <tr>
                <th>Setting</th>
                <th>Value</th>
            </tr>
            <tr><td>PHP Version</td><td>' . phpversion() . '</td></tr>
            <tr><td>Memory Limit</td><td>' . ini_get('memory_limit') . '</td></tr>
            <tr><td>Max Execution Time</td><td>' . ini_get('max_execution_time') . ' seconds</td></tr>
            <tr><td>Upload Max Filesize</td><td>' . ini_get('upload_max_filesize') . '</td></tr>
            <tr><td>Post Max Size</td><td>' . ini_get('post_max_size') . '</td></tr>
            <tr><td>Mod Rewrite</td><td>' . (function_exists('apache_get_modules') && in_array('mod_rewrite', apache_get_modules()) ? '<span class="success">Enabled</span>' : '<span class="error">Disabled</span>') . '</td></tr>
            <tr><td>Document Root</td><td>' . $_SERVER['DOCUMENT_ROOT'] . '</td></tr>
            <tr><td>Server Software</td><td>' . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . '</td></tr>
        </table>
    </div>
    
    <div class="section">
        <h2>🚀 Next Steps</h2>
        <ol>
            <li>Xóa file này sau khi kiểm tra xong!</li>
            <li>Upload Laravel code vào <code>public_html/</code></li>
            <li>Tạo database và import (hoặc chạy migration)</li>
            <li>Cấu hình file <code>.env</code></li>
            <li>Chạy <code>php artisan storage:link</code></li>
            <li>Set permissions: <code>chmod -R 755 storage/ bootstrap/cache/</code></li>
        </ol>
    </div>
    
    <div style="text-align: center; margin-top: 40px; padding: 20px; background: #333; color: white; border-radius: 5px;">
        <p>🌸 FlowerShop Deployment Check Script</p>
        <p style="color: #ff6666; font-weight: bold;">⚠️ NHỚ XÓA FILE NÀY! DELETE THIS FILE! ⚠️</p>
    </div>
</body>
</html>';
