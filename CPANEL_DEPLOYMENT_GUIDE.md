# 🌸 Hướng Dẫn Deploy Laravel lên cPanel

Hướng dẫn chi tiết để deploy project FlowerShop lên hosting cPanel.

---

## 📋 Mục Lục

1. [Yêu Cầu Hệ Thống](#-yêu-cầu-hệ-thống)
2. [Chuẩn Bị Trước Khi Upload](#-chuẩn-bị-trước-khi-upload)
3. [Cấu Trúc Thư Mục](#-cấu-trúc-thư-mục)
4. [Upload Code lên cPanel](#-upload-code-lên-cpanel)
5. [Cài Đặt Database](#-cài-đặt-database)
6. [Cấu Hình Environment](#-cấu-hình-environment)
7. [Setup Storage & Symlink](#-setup-storage--symlink)
8. [Permissions (Phân Quyền)](#-permissions-phân-quyền)
9. [Chạy Migration](#-chạy-migration)
10. [Kiểm Tra Sau Deploy](#-kiểm-tra-sau-deploy)
11. [Xử Lý Lỗi Thường Gặp](#-xử-lý-lỗi-thường-gặp)

---

## 🔧 Yêu Cầu Hệ Thống

### Server Requirements
- **PHP**: 8.2 hoặc cao hơn
- **MySQL**: 5.7+ hoặc MariaDB 10.3+
- **Apache**: 2.4+ với mod_rewrite enabled
- **Extensions cần thiết**:
  - PHP Extension: `pdo`, `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `curl`

### Kiểm tra phiên bản PHP trên cPanel
1. Đăng nhập cPanel
2. Vào **MultiPHP Manager** hoặc **PHP Version**
3. Chọn phiên bản PHP 8.2+

---

## 📦 Chuẩn Bị Trước Khi Upload

### Bước 1: Chạy lệnh tối ưu production

```bash
# Trên máy local trước khi upload
composer install --optimize-autoloader --no-dev

# Clear cache
php artisan optimize:clear

# Cache config và routes
php artisan config:cache
php artisan route:cache

# Compile assets (nếu có npm)
npm run build
```

### Bước 2: Kiểm tra các file cần thiết

Đảm bảo có đủ các file sau:
- ✅ `public/.htaccess` - đã cấu hình
- ✅ `.htaccess` ở root - redirect vào public
- ✅ `.env` - file cấu hình
- ✅ `composer.json` và `composer.lock`
- ✅ `storage/` - thư mục storage
- ✅ `bootstrap/cache/` - thư mục cache

### Bước 3: Tạo file .env production

```bash
# Copy file .env.example thành .env
# Sau đó chỉnh sửa các giá trị:
```

Nội dung `.env` cho production:
```env
APP_NAME="Lâm Nhiên Thảo"
APP_ENV=production
APP_KEY=base64:GENERATE_THIS_WITH_php_artisan_key_generate
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Lâm Nhiên Thảo"
```

---

## 📁 Cấu Trúc Thư Mục

### Cách 1: Upload trực tiếp vào `public_html` (Khuyến nghị)

```
public_html/                    ← Upload to here
├── .htaccess                   ← Main .htaccess
├── index.php
├── css/
│   └── app.css
├── js/
├── images/
├── web.config
└── (other public files)

├── app/                       ← Application code
├── bootstrap/
│   └── cache/
├── config/
├── database/
├── lang/
├── public/                    ← (Skip this in root)
├── resources/
├── routes/
├── storage/                   ← Must be writable
├── vendor/
├── .env
└── composer.json
```

### Cách 2: Upload vào thư mục con

Nếu muốn đặt code trong thư mục con (ví dụ `/flowershop`):

```
public_html/
├── .htaccess                  ← Redirect to /flowershop/public
└── (empty - website root)

flowershop/                    ← Full Laravel code
├── app/
├── bootstrap/
├── config/
├── public/                    ← Point Apache here
├── storage/
├── vendor/
├── .env
└── composer.json
```

---

## 📤 Upload Code lên cPanel

### Phương pháp 1: File Manager (Đơn giản)

1. Đăng nhập cPanel
2. Mở **File Manager**
3. Navigate đến `public_html/`
4. Click **Upload**
5. Upload file `.zip` chứa toàn bộ code
6. Sau khi upload xong, right-click → **Extract**
7. Đảm bảo code nằm đúng vị trí

### Phương pháp 2: FTP/FileZilla

```bash
# FTP Credentials (lấy từ cPanel)
Host: ftp.your-domain.com
Port: 21
Username: your-ftp-username
Password: your-ftp-password

# Upload thư mục vào public_html/
```

### Phương pháp 3: SSH (Nếu có)

```bash
# Kết nối SSH
ssh your-username@your-domain.com

# Upload qua SCP
scp -r ./flowershop your-username@your-domain.com:public_html/
```

---

## 🗄️ Cài Đặt Database

### Bước 1: Tạo Database

1. Đăng nhập cPanel
2. Mở **MySQL Database Wizard**
3. Tạo database: `your_db_name`
4. Tạo user: `your_db_user`
5. Gán quyền: **ALL PRIVILEGES**

### Bước 2: Import Database

1. Mở **phpMyAdmin** trong cPanel
2. Chọn database vừa tạo
3. Click **Import**
4. Upload file SQL (nếu có backup)
5. Hoặc để trống - sẽ tạo mới khi chạy migration

---

## ⚙️ Cấu Hình Environment

### Cách 1: Sửa .env trực tiếp

1. Trong File Manager, navigate đến thư mục chứa code
2. Right-click on `.env` → **Edit**
3. Cập nhật các giá trị:
   - `APP_URL` = https://your-domain.com
   - `DB_HOST` = localhost
   - `DB_DATABASE` = tên database đã tạo
   - `DB_USERNAME` = user database đã tạo
   - `DB_PASSWORD` = password database

### Cách 2: Sử dụng Laravel Artisan (SSH)

```bash
# Kết nối SSH
ssh your-username@your-domain.com

# Di chuyển đến thư mục project
cd public_html/flowershop  # hoặc /public_html nếu upload trực tiếp

# Generate app key
php artisan key:generate

# Hoặc set key thủ công
php artisan key:generate --force
```

---

## 📂 Setup Storage & Symlink

### Vấn đề thường gặp

Laravel cần symlink từ `public/storage` đến `storage/app/public` để hiển thị uploaded images.

### Cách 1: Qua SSH (Khuyến nghị)

```bash
# Kết nối SSH đến server
ssh your-username@your-domain.com

# Di chuyển đến thư mục project
cd ~/public_html/flowershop  # hoặc đường dẫn phù hợp

# Tạo symlink
php artisan storage:link

# Output: The [public/storage] directory has been linked.
```

### Cách 2: Qua PHP Script (Nếu không có SSH)

Tạo file `setup-storage.php` trong thư mục project:

```php
<?php
// Chạy file này 1 lần qua browser
// Sau đó XÓA file này ngay lập tức

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Tạo symlink
if (!file_exists(public_path('storage'))) {
    symlink(storage_path('app/public'), public_path('storage'));
    echo "Storage linked successfully!";
} else {
    echo "Storage already linked.";
}
```

**⚠️ QUAN TRỌNG:** Sau khi chạy xong, **XÓA NGAY** file `setup-storage.php`!

### Cách 3: Thủ công qua File Manager

1. Mở File Manager
2. Navigate đến `public_html/flowershop/storage/app/`
3. Tạo thư mục `public`
4. Navigate đến `public_html/flowershop/public/`
5. Tạo symlink (hoặc copy thư mục `storage` vào đây)

---

## 🔐 Permissions (Phân Quyền)

### Các thư mục cần Write Permission

```bash
# Qua SSH
chmod 755 storage/
chmod 755 storage/app/
chmod 755 storage/app/public/
chmod 755 storage/framework/
chmod 755 storage/framework/cache/
chmod 755 storage/framework/sessions/
chmod 755 storage/framework/views/
chmod 755 bootstrap/cache/

# Files
chmod 644 .env
```

### Qua File Manager

1. Right-click vào thư mục
2. Chọn **Change Permissions**
3. Set:
   - Owner: Read, Write, Execute
   - Group: Read, Execute
   - Public: Read, Execute
   - (755)

### Bảng Permissions

| Thư mục/File | Permission | Mô tả |
|--------------|------------|--------|
| `storage/` | 755 | Thư mục storage chính |
| `storage/app/` | 755 | App storage |
| `storage/app/public/` | 755 | Public uploads |
| `storage/framework/` | 755 | Framework cache |
| `storage/framework/cache/` | 755 | Cache files |
| `storage/framework/sessions/` | 755 | Session files |
| `storage/framework/views/` | 755 | Compiled views |
| `bootstrap/cache/` | 755 | Bootstrap cache |
| `.env` | 644 | Environment file |
| `artisan` | 644 | Artisan file |

---

## 🚀 Chạy Migration

### Qua SSH

```bash
# Kết nối SSH
ssh your-username@your-domain.com

# Di chuyển đến project
cd ~/public_html/flowershop

# Chạy migration
php artisan migrate

# Seed data (nếu cần)
php artisan db:seed

# Hoặc reset và seed
php artisan migrate:fresh --seed
```

### Qua Laravel Route (Development ONLY)

⚠️ **KHÔNG SỬ DỤNG** trong production! Chỉ dùng khi không có SSH.

Tạo route tạm trong `routes/web.php`:

```php
Route::get('/setup-migrate', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    return 'Migration completed! DELETE THIS ROUTE!';
});
```

Sau đó truy cập: `https://your-domain.com/setup-migrate`

**⚠️ QUAN TRỌNG:** Sau khi chạy xong, **XÓA NGAY** route này!

---

## ✅ Kiểm Tra Sau Deploy

### 1. Kiểm tra trang chủ

```
https://your-domain.com
```

### 2. Kiểm tra admin panel

```
https://your-domain.com/admin
```

### 3. Kiểm tra storage link

```bash
# SSH
php artisan storage:link

# Hoặc kiểm tra file manager
# Đảm bảo có symlink từ public/storage đến storage/app/public
```

### 4. Kiểm tra permissions

- `storage/` và subfolders phải có quyền write
- `bootstrap/cache/` phải có quyền write
- `.env` phải readable nhưng không editable từ web

### 5. Kiểm tra PHP version

```bash
php -v  # SSH
# Hoặc tạo file info.php:
<?php phpinfo();
```

---

## 🐛 Xử Lý Lỗi Thường Gặp

### Lỗi 1: 500 Internal Server Error

**Nguyên nhân thường gặp:**
- .htaccess có lỗi
- PHP version không đúng
- Permissions không đúng

**Cách fix:**
```bash
# Kiểm tra Apache error log
tail -f /usr/local/apache/logs/error_log

# Reset permissions
find storage -type d -exec chmod 755 {} \;
chmod 755 bootstrap/cache/
```

### Lỗi 2: Database Connection Error

**Kiểm tra:**
1. Thông tin database trong `.env` có đúng không?
2. Database user có quyền truy cập database không?
3. MySQL service có đang chạy không?

```env
DB_HOST=localhost           # Thường là localhost
DB_PORT=3306               # Port mặc định
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_password
```

### Lỗi 3: White Screen / Blank Page

**Nguyên nhân:**
- `APP_DEBUG=false` nhưng có lỗi
- Cache không clear

**Cách fix:**
```bash
# Bật debug مؤقت
# Sửa .env:
APP_DEBUG=true
APP_LOG_LEVEL=debug

# Clear cache
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
```

### Lỗi 4: 404 Not Found

**Nguyên nhân:**
- mod_rewrite không enable
- .htaccess không hoạt động

**Cách fix:**
1. Đăng nhập cPanel
2. Vào **MultiPHP INI Editor**
3. Kiểm tra `mod_rewrite` đã enabled chưa
4. Hoặc thêm vào `.htaccess`:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
</IfModule>
```

### Lỗi 5: Permission Denied on Storage

```bash
# SSH commands
cd ~/public_html
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R nobody nobody storage/
```

### Lỗi 6: Images not loading

**Nguyên nhân:** Storage symlink chưa được tạo

**Cách fix:**
```bash
# SSH
php artisan storage:link

# Hoặc kiểm tra symlink có tồn tại không
ls -la public/storage
```

### Lỗi 7: APP_KEY not set

```bash
# Generate new key
php artisan key:generate

# Hoặc set thủ công
php artisan key:generate --force
```

### Lỗi 8: CORS Error với API

Kiểm tra `.htaccess` có header CORS chưa:

```apache
Header set Access-Control-Allow-Origin "*"
Header set Access-Control-Allow-Methods "GET, POST, PUT, DELETE, OPTIONS"
Header set Access-Control-Allow-Headers "Content-Type, Authorization"
```

---

## 📋 Checklist Trước Khi Deploy

- [ ] PHP version: 8.2+
- [ ] MySQL/MariaDB database đã tạo
- [ ] Database user đã tạo với quyền đầy đủ
- [ ] Code đã upload lên `public_html/`
- [ ] File `.env` đã cấu hình đúng
- [ ] Permissions đã set đúng (755 cho folders)
- [ ] Storage symlink đã tạo
- [ ] Migration đã chạy
- [ ] Debug mode đã tắt (`APP_DEBUG=false`)
- [ ] Test website hoạt động

---

## 🔒 Bảo Mật Sau Deploy

### 1. Tắt Directory Listing
```apache
# Trong .htaccess
Options -Indexes
```

### 2. Bảo vệ .env file
```apache
# Trong .htaccess
<Files ".env">
    Order allow,deny
    Deny from all
</Files>
```

### 3. Disable PHP execution trong storage
```apache
# Tạo file .htaccess trong storage/
# nội dung:
<Files *>
    Order allow,deny
    Deny from all
</Files>
```

### 4. HTTPS redirect
```apache
# Trong .htaccess
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 📞 Hỗ Trợ

Nếu gặp lỗi không có trong danh sách:

1. Bật `APP_DEBUG=true` trong `.env`
2. Kiểm tra error logs trong `storage/logs/`
3. Kiểm tra Apache error log trong cPanel
4. Test từng bước trong hướng dẫn này

---

**Version:** 1.0
**Last Updated:** September 2026
**Compatible with:** Laravel 11, PHP 8.2+, cPanel
