# 🌸 Checklist Sau Khi Upload Code Lên cPanel

## ✅ Các Bước Còn Lại (Thực Hiện Theo Thứ Tự)

---

### Bước 1: Tạo Database (trong cPanel)

1. Đăng nhập **cPanel**
2. Mở **MySQL Database Wizard**
3. Tạo database: ví dụ `lamnhienthao_db`
4. Tạo user: ví dụ `lamnhienthao_user`
5. Gán quyền: **ALL PRIVILEGES**
6. **Ghi lại** tên DB, username, password (cần cho bước 3)

---

### Bước 2: Tạo File `.env`

1. Trong **File Manager**, tìm file `.env.example`
2. Right-click → **Copy** → đặt tên là `.env`
3. Right-click vào `.env` → **Edit**
4. Thay thế nội dung bằng (sửa thông tin của bạn):

```env
APP_NAME="Lâm Nhiên Thảo"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=sync

MAIL_MAILER=log
```

---

### Bước 3: Generate APP_KEY

**Cách A - Qua SSH (nếu có):**
```bash
ssh your-username@your-domain.com
cd public_html
php artisan key:generate
```

**Cách B - Qua website:**
1. Upload file `generate-key.php` (file đính kèm)
2. Truy cập `https://your-domain.com/generate-key.php`
3. Copy KEY được tạo
4. Paste vào file `.env` tại dòng `APP_KEY=`
5. **XÓA file `generate-key.php` ngay!**

---

### Bước 4: Set Quyền (Permissions)

Trong **File Manager**, click chọn thư mục → **Permissions**:

| Thư mục | Permission |
|---------|------------|
| `storage/` | 755 |
| `storage/app/` | 755 |
| `storage/app/public/` | 755 |
| `storage/framework/` | 755 |
| `storage/framework/cache/` | 755 |
| `storage/framework/sessions/` | 755 |
| `storage/framework/views/` | 755 |
| `bootstrap/cache/` | 755 |

Cách set: Right-click → Change Permissions → Tick **Read, Write, Execute** cho Owner

---

### Bước 5: Tạo Storage Symlink

1. Upload file `storage-link.php` lên thư mục chính
2. Truy cập `https://your-domain.com/storage-link.php`
3. Thấy thông báo "Storage linked successfully!"
4. **XÓA file `storage-link.php` ngay!**

---

### Bước 6: Chạy Migration (Tạo bảng)

1. Upload file `run-migrate.php` lên thư mục chính
2. Truy cập `https://your-domain.com/run-migrate.php`
3. Thấy thông báo "Migration completed!"
4. **XÓA file `run-migrate.php` ngay!**

---

### Bước 7: Chạy Diagnostic

1. Upload file `diagnostic.php` lên thư mục chính
2. Truy cập `https://your-domain.com/diagnostic.php`
3. Xem báo cáo - các mục ✅ là OK, ❌ là cần fix

---

### Bước 8: Xóa File Tạm

**QUAN TRỌNG!** Sau khi hoàn thành, xóa tất cả file tạm:
- `generate-key.php`
- `storage-link.php`
- `run-migrate.php`
- `diagnostic.php`

---

## 🔍 Kiểm Tra Website

1. **Trang chủ:** `https://your-domain.com`
2. **Admin:** `https://your-domain.com/admin`
3. **Đăng nhập:** `https://your-domain.com/login`

---

## ⚠️ Nếu Vẫn Lỗi 500

1. Sửa `.env`: đổi `APP_DEBUG=true` مؤقت
2. Reload trang → sẽ hiện lỗi cụ thể
3. Fix lỗi → đổi lại `APP_DEBUG=false`
4. Xóa cache: thêm `?clear=cache` vào URL

---

## 📁 Các File Helper Cần Upload

- `generate-key.php` - Tạo APP_KEY
- `storage-link.php` - Tạo symlink
- `run-migrate.php` - Chạy migration
- `diagnostic.php` - Kiểm tra lỗi
