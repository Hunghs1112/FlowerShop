# 🚀 Hướng Dẫn Di Chuyển File Từ public/ Ra public_html/

## Tình huống hiện tại:
Bạn đã upload toàn bộ code vào `public_html/`, bao gồm cả thư mục `public/`

## ⚠️ Vấn đề:
- Browser đang cố truy cập `public_html/` nhưng file `index.php` lại nằm trong `public_html/public/`
- Nên gặp lỗi 403 Forbidden

## ✅ Giải pháp: Di chuyển nội dung public/ ra ngoài

### Bước 1: Trên cPanel File Manager

1. Vào **cPanel → File Manager**
2. Mở thư mục `public_html/`
3. Vào thư mục `public_html/public/`
4. **Select All** (Ctrl+A) - chọn TẤT CẢ file trong `public/`:
   - index.php
   - .htaccess
   - css/
   - js/
   - images/
   - favicon.ico
   - robots.txt
   - v.v.

5. Click **Move** (Di chuyển)
6. Đích đến: `/public_html/` (lên 1 cấp)
7. Confirm → Move

### Bước 2: Xóa thư mục public/ trống

Sau khi di chuyển xong, xóa thư mục `public_html/public/` (đã trống)

### Bước 3: Sửa đường dẫn trong index.php

Mở file `public_html/index.php`, tìm dòng:

```php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

Sửa thành (bỏ `../` vì giờ index.php nằm cùng cấp):

```php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
```

### Bước 4: Kiểm tra cấu trúc cuối cùng

```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
├── index.php          ← Đây là Laravel entry point
├── .htaccess          ← Laravel rewrite rules
├── .env               ← Config
├── artisan
├── composer.json
├── css/               ← Static assets
├── js/
└── images/
```

## 🧪 Test

Truy cập: `http://lamnhienthao.com`

Nếu vẫn lỗi, tiếp tục đến Bước 5.

### Bước 5: Set permissions (nếu vẫn lỗi 403)

Trên cPanel File Manager:

1. Click chuột phải vào `public_html/`
2. Chọn **Change Permissions**
3. Set:
   - Thư mục: `755` (rwxr-xr-x)
   - File: `644` (rw-r--r--)

4. Check ☑ "Change permissions recursively"
5. Apply

### Bước 6: Set quyền cho storage/ và bootstrap/cache/

```bash
# Trên Terminal SSH (nếu có):
cd /home/username/public_html
chmod -R 775 storage bootstrap/cache
```

Hoặc trên File Manager:
- `storage/` → Permissions → `775`
- `bootstrap/cache/` → Permissions → `775`
- Check "recursive"

## 🔍 Debug nếu vẫn lỗi

### Kiểm tra file .htaccess

File `.htaccess` trong `public_html/` phải có nội dung:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### Kiểm tra PHP version

cPanel → MultiPHP Manager → Chọn domain → PHP 8.2+

### Check error log

cPanel → Metrics → Errors → xem lỗi cụ thể

---

## ⚡ Nếu không muốn di chuyển file

### Giải pháp thay thế: Dùng .htaccess redirect

Tạo file `.htaccess` trong `public_html/` (root):

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_URI} !^/public/
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

Nhưng cách này **KHÔNG KHUYẾN NGHỊ** vì:
- ❌ Để lộ code Laravel (app/, config/, .env)
- ❌ Bảo mật kém
- ❌ Có thể bị truy cập trực tiếp vào file nhạy cảm

---

## 🎯 Tóm tắt:

**Khuyến nghị**: Di chuyển nội dung `public/` ra `public_html/` và sửa đường dẫn trong `index.php`

**Nhanh nhất**: Dùng .htaccess redirect (nhưng kém bảo mật)
