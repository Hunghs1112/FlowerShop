# Image Storage — Quy tắc bất biến

## Hai hệ thống lưu ảnh (KHÔNG được trộn lẫn)

### Hệ thống A — Storage Disk `public` (mọi upload trừ banner)
- **Vị trí thực:** `storage/app/public/{folder}/{file}`
- **URL truy cập:** `/storage/{folder}/{file}` — thông qua symlink `public/storage → storage/app/public`
- **Dùng cho:** products, categories, subcategories, posts, settings/logo, variants
- **DB lưu:** path tương đối, ví dụ `products/abc123.jpg`, `categories/xyz.jpg`
- **Tạo URL trong view:** **luôn dùng model accessor** (xem bên dưới)
- **Tạo URL trong accessor/service:** `asset('storage/' . $path)`

### Hệ thống B — `public/images/` (banners + static assets)
- **Vị trí thực:** `public/images/banners/{file}` (nằm thẳng trong webroot, không cần symlink)
- **URL truy cập:** `/images/banners/{file}`
- **Dùng cho:** banners upload qua admin
- **DB lưu:** `images/banners/file.jpg` (bắt đầu bằng `images/`)
- **Tạo URL:** `asset('images/banners/file.jpg')` — tức là `asset($path)` khi path bắt đầu bằng `images/`

---

## Quy tắc tạo URL ảnh — BẮT BUỘC

### ✅ ĐÚNG — Luôn dùng model accessor trong Blade views

```blade
{{-- Products --}}
<img src="{{ $image->image_url }}">

{{-- Categories / Subcategories --}}
<img src="{{ $category->image_url }}">
<img src="{{ $category->hover_image_url }}">
<img src="{{ $subcategory->image_url }}">

{{-- Banners --}}
<img src="{{ $banner->image_url }}">

{{-- Posts --}}
<img src="{{ $post->image_url }}">
```

### ❌ SAI — Không bao giờ hardcode prefix trong view

```blade
{{-- KHÔNG làm thế này --}}
<img src="{{ asset('storage/' . $image->image_path) }}">
<img src="{{ asset('storage/' . $category->image) }}">
<img src="{{ asset($thumbnail) }}">
```

---

## Logic chuẩn trong Model Accessor

```php
// Mẫu chuẩn cho accessor của System A (storage disk)
public function getImageUrlAttribute(): string
{
    if (!$this->image_path) {
        return asset('images/placeholder.jpg');
    }
    if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
        return $this->image_path;
    }
    return asset('storage/' . ltrim($this->image_path, '/'));
}

// Mẫu chuẩn cho Banner (System B — public/images/)
public function getImageUrlAttribute(): string
{
    if (!$this->image_path) {
        return asset('images/placeholder-banner.jpg');
    }
    if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
        return $this->image_path;
    }
    // Banner path bắt đầu bằng 'images/' → serve trực tiếp qua asset()
    if (str_starts_with($this->image_path, 'images/')) {
        return asset($this->image_path);
    }
    return asset('storage/' . ltrim($this->image_path, '/'));
}
```

---

## Docker — Volume và Symlink

### Cấu hình docker-compose.yml
```yaml
volumes:
  - .:/var/www/html                      # bind mount toàn project
  - storage:/var/www/html/storage        # named volume OVERLAY lên storage/
  - /var/www/html/vendor                 # anonymous (loại trừ vendor khỏi bind)
  - /var/www/html/node_modules           # anonymous (loại trừ node_modules)
```

**Quan trọng:** Named volume `storage` tồn tại độc lập. Ảnh upload không bị mất khi restart container (chỉ mất khi `docker compose down -v`).

### entrypoint.sh chạy mỗi lần container start
1. `php artisan key:generate` (nếu chưa có APP_KEY)
2. `php artisan config:clear`
3. `php artisan migrate --force`
4. `mkdir -p storage/app/public/images && cp -R public/images/. storage/app/public/images/` — copy static images vào named volume
5. `php artisan storage:link --force` — tạo lại symlink `public/storage`
6. `php artisan config:cache`

### APP_URL
- Docker expose port **8080** → APP_URL phải là `http://localhost:8080`
- `asset()` dùng APP_URL để build URL đầy đủ → sai APP_URL = toàn bộ ảnh sai domain

---

## Khi thêm loại ảnh mới

1. Upload qua `ImageStorageService::upload($file, $folder)` — folder phải khớp với `config/upload.php disks.folders`
2. DB lưu path tương đối (ví dụ `products/file.jpg`), không lưu `/storage/` hay URL đầy đủ
3. Thêm accessor `getXxxUrlAttribute()` trong model theo mẫu System A ở trên
4. View chỉ dùng accessor, không hardcode prefix

---

## Checklist khi debug ảnh bị lỗi

- [ ] `public/storage` có phải symlink không? (`ls -la public/storage`)
- [ ] Symlink trỏ đến `../storage/app/public` không?
- [ ] File có tồn tại trong named volume không? (`docker exec flowershop-app ls storage/app/public/{folder}`)
- [ ] DB path có đúng định dạng không (không có `/storage/` prefix, không có URL đầy đủ)?
- [ ] View dùng accessor chứ không hardcode?
- [ ] APP_URL trong docker-compose có phải `http://localhost:8080` không?
