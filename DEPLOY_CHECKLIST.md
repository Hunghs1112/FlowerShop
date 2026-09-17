# 🚀 Deploy Checklist - cPanel

## Trước Khi Upload

### 1. Local Preparation
```bash
# Tối ưu composer (production)
composer install --optimize-autoloader --no-dev

# Generate key (nếu chưa có)
php artisan key:generate

# Clear và cache
php artisan optimize:clear
php artisan config:cache
php artisan route:cache

# Build assets
npm run build
```

### 2. Chuẩn bị File Upload
- [ ] `.env` - đã cấu hình production
- [ ] `.env.production` - backup config
- [ ] `public/.htaccess` - đã cấu hình
- [ ] `.htaccess` root - redirect
- [ ] `storage/` - đầy đủ
- [ ] `bootstrap/cache/` - tồn tại

### 3. Tạo ZIP để upload
```bash
# Exclude development files
zip -r flowershop-deploy.zip . \
  --exclude "*.git*" \
  --exclude "node_modules/*" \
  --exclude ".env" \
  --exclude ".env.example" \
  --exclude "*.md" \
  --exclude "docker*" \
  --exclude "*.ps1" \
  --exclude "*.sh" \
  --exclude "*.sqlite"
```

---

## Trên cPanel

### 1. Kiểm tra System Requirements
- [ ] PHP 8.2+
- [ ] MySQL/MariaDB
- [ ] mod_rewrite enabled

### 2. Tạo Database
- [ ] Tạo MySQL Database
- [ ] Tạo Database User
- [ ] Gán quyền ALL PRIVILEGES

### 3. Upload & Extract
- [ ] Upload ZIP vào `public_html/`
- [ ] Extract file
- [ ] Di chuyển files ra đúng vị trí (nếu cần)

### 4. Cấu hình Environment
- [ ] Upload `.env` đã chỉnh sửa
- [ ] Hoặc sửa `.env` trong File Manager

### 5. Set Permissions
```bash
# SSH
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 644 .env
chmod 644 artisan
```

Hoặc qua File Manager:
- [ ] `storage/` → 755
- [ ] `bootstrap/cache/` → 755
- [ ] `.env` → 644

### 6. Storage Link
```bash
# SSH
php artisan storage:link
```

Hoặc dùng script `setup-storage.php` (xóa sau khi dùng)

### 7. Chạy Migration
```bash
# SSH
php artisan migrate
php artisan db:seed  # nếu cần
```

### 8. Kiểm tra
- [ ] Website frontend hoạt động
- [ ] Admin panel hoạt động
- [ ] Images hiển thị (storage link)
- [ ] Database connection OK

---

## Sau Khi Deploy Thành Công

### 1. Bảo Mật
- [ ] Xóa file `cpanel-check.php`
- [ ] Xóa file `setup-storage.php` (nếu dùng)
- [ ] Xóa route migrate tạm (nếu có)
- [ ] Tắt `APP_DEBUG=false`
- [ ] Kiểm tra `.env` không accessible từ web

### 2. Monitoring
- [ ] Check error logs trong `storage/logs/`
- [ ] Setup error reporting email (optional)

### 3. Backup
- [ ] Backup database
- [ ] Backup files

---

## Quick Commands (SSH)

```bash
# Navigate
cd ~/public_html/flowershop

# Permissions
chmod -R 755 storage/ bootstrap/cache/

# Generate key
php artisan key:generate

# Storage link
php artisan storage:link

# Migration
php artisan migrate --force

# Clear cache
php artisan optimize:clear

# Check routes
php artisan route:list

# Update bootstrap
composer dump-autoload --optimize
```

---

## Emergency Rollback

Nếu deploy thất bại:

1. **Backup hiện tại** (trước khi rollback)
```bash
mv ~/public_html/flowershop ~/public_html/flowershop-backup
```

2. **Khôi phục version cũ**
```bash
mv ~/public_html/flowershop-old ~/public_html/flowershop
```

3. **Restore database** (nếu cần)
- phpMyAdmin → Export/Import

---

**Đã deploy thành công?**
- Cập nhật `APP_DEBUG=false`
- Enable HTTPS (Let's Encrypt - có sẵn trong cPanel)
- Setup cronjob cho scheduler (nếu cần)
