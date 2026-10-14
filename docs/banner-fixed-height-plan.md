# Plan: Khóa chiều cao banner cố định

## Context

Hiện tại chiều cao banner được cấu hình bởi admin qua 2 ô input number (`banner_{key}_height_desktop` và `banner_{key}_height_mobile`). Các giá trị này được inject vào blade dưới dạng CSS vars `--banner-height-desktop/mobile` nhưng **không một CSS file nào tham chiếu** chúng — hoàn toàn vô hiệu. Người dùng đặt height tùy ý trong khi ảnh upload vẫn crop tùy theo CSS.

**Yêu cầu:** Khóa chiều cao theo slot cố định. Người dùng chỉ upload ảnh, ảnh tự crop vào khung qua `object-fit: cover`. Bỏ hoàn toàn phần cấu hình chiều cao trong admin.

---

## Chiều cao cố định theo slot

Dựa trên ảnh production chuẩn **2576×980** (tỉ lệ 2.629):

| Slot | Trang | Desktop | Mobile (≤767px) | Tỉ lệ khung desktop |
|---|---|---|---|---|
| `products` | `/san-pham` | **400px** | **200px** | 1280/400 = 3.2 |
| `categories` | `/danh-muc`, `/danh-muc/[slug]` | **400px** | **200px** | 3.2 |
| `blog` | `/bai-viet` | **320px** | **180px** | 4.0 |
| `b2c` | `/b2c` | **400px** | **200px** | 3.2 |
| `mystery-box` | `/hop-hoa-bi-an` | **400px** | **200px** | 3.2 |
| `cart` | `/gio-hang` | **280px** | **160px** | 4.6 |
| `checkout` | `/thanh-toan` | **280px** | **160px** | 4.6 |
| `home` | `/` | **giữ nguyên** (padding clamp) | — | — |
| `about` | `/gioi-thieu` | **giữ nguyên** (inline CSS riêng) | — | — |
| `contact` | `/lien-he` | **giữ nguyên** (inline CSS riêng) | — | — |
| Seasonal | `/mua-le-hoi/*` | **giữ nguyên** (`shero`/`shead`) | — | — |
| Policy pages | `/chinh-sach-*`, `/dieu-khoan-*` | **giữ nguyên** (inline CSS riêng) | — | — |

> Trang `about`, `contact`, policy, guide, seasonal: giữ nguyên vì dùng inline `@push` CSS riêng hoặc artwork tích hợp. Không nằm trong hệ thống `<x-page-hero>`.

---

## Các bước thực hiện

### Bước 1: Thêm CSS cố định cho `.page-hero--with-image`
**File:** `public/css/page-hero.css`

Thêm media query cho chiều cao cố định:
```css
/* Default (desktop ≥768px): height cố định */
.page-hero--with-image {
    height: 400px; /* fallback cho products/b2c/mystery-box */
}

/* Tablet 768-1024 */
@media (max-width: 1024px) {
    .page-hero--with-image { height: 320px; }
}

/* Mobile ≤767px */
@media (max-width: 767px) {
    .page-hero--with-image { height: 200px; }
}
```

Và thêm `object-position: center top` để ưu tiên crop phần trên ảnh (hoa thường ở trên):
```css
.page-hero-background-image {
    object-fit: cover;
    object-position: center top;
}
```

**Override theo variant** (blog nhỏ hơn, cart/checkout nhỏ nhất):
```css
/* Blog variant: nhỏ hơn */
.page-hero--variant-blog.page-hero--with-image { height: 320px; }
@media (max-width: 767px) { .page-hero--variant-blog.page-hero--with-image { height: 180px; } }

/* Cart/checkout: compact nhất */
.page-hero--variant-cart.page-hero--with-image,
.page-hero--variant-checkout.page-hero--with-image { height: 280px; }
@media (max-width: 767px) {
    .page-hero--variant-cart.page-hero--with-image,
    .page-hero--variant-checkout.page-hero--with-image { height: 160px; }
}
```

→ Thêm prop `variant` vào `<x-page-hero>` (vd. `variant="blog"`, `variant="cart"`).

### Bước 2: Thêm CSS cho `.products-hero--image-only`
**File:** `public/css/products/hero.css`

```css
.products-hero--image-only {
    height: 400px;
}
@media (max-width: 767px) {
    .products-hero--image-only { height: 200px; }
}
.products-hero-image {
    object-fit: cover;
    object-position: center top;
}
```

### Bước 3: Tạo CSS cho `.categories-hero` (HIỆN KHÔNG CÓ)
**File:** `public/css/categories-hero.css` (file mới)

Đây là class đang được dùng ở `/danh-muc` nhưng không có rule nào. Tạo file mới, import vào `app.css`:

```css
.categories-hero {
    position: relative;
    height: 400px;
    background-color: var(--color-botanical-pale);
    overflow: hidden;
}
@media (max-width: 767px) {
    .categories-hero { height: 200px; }
}
.categories-hero-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
}
.categories-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgba(32,36,31,0.7) 0%, rgba(32,36,31,0.3) 100%);
}
.categories-hero-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: clamp(1rem,3vw,2rem);
}
.categories-hero-heading { /* heading styles */ }
.categories-hero-description { /* description styles */ }
```

### Bước 4: Thêm prop `variant` vào `<x-page-hero>`
**File:** `resources/views/components/page-hero.blade.php`

```blade
{{-- Thêm prop variant, default null --}}
@props(['image' => null, 'title' => '', 'description' => '', 'label' => '', 'breadcrumbs' => [], 'hideOverlay' => false, 'hideContent' => false, 'bannerKey' => null, 'variant' => null])

{{-- Thêm variant vào class --}}
<section class="page-hero {{ $image ? 'page-hero--with-image' : '' }} {{ $variant ? 'page-hero--variant-' . $variant : '' }} ...">
```

### Bước 5: Cập nhật các blade truyền `<x-page-hero>` có variant
- `cart/index.blade.php` → `<x-page-hero ... variant="cart">`
- `blog/show.blade.php` → `<x-page-hero ... variant="blog">`
- `checkout/index.blade.php` → `<x-page-hero ... variant="checkout">`
- `products/index.blade.php` → `<x-page-hero ... variant="products">`

### Bước 6: Xóa CSS var injection khỏi blade
**3 file cần sửa:**

**`resources/views/components/page-hero.blade.php`:**
```blade
{{-- XÓA --}}
@php($bannerSize = $bannerKey ? ($siteBannerSizes[$bannerKey] ?? null) : null)
{{-- XÓA khỏi style="" --}}
style="{{ $bannerSize ? '--banner-height-desktop: ...' : '' }}"
```

**`resources/views/products/index.blade.php`:**
```blade
{{-- TRƯỚC --}}
<section class="products-hero ..." style="--banner-height-desktop: {{ $siteBannerSizes['categories']['desktop'] }}px; --banner-height-mobile: ...">

{{-- SAU --}}
<section class="products-hero {{ $activeCategory?->hide_banner_content ? 'products-hero--image-only' : '' }}">
```

**`resources/views/categories/index.blade.php`:**
```blade
{{-- TRƯỚC --}}
<section class="categories-hero" style="--banner-height-desktop: {{ $siteBannerSizes['categories']['desktop'] }}px; --banner-height-mobile: ...">

{{-- SAU --}}
<section class="categories-hero">
```

**`resources/views/categories/show.blade.php`:**
```blade
{{-- TRƯỚC --}}
<section class="products-hero {{ ... }}" style="--banner-height-desktop: {{ $siteBannerSizes['categories']['desktop'] }}px; ...">

{{-- SAU --}}
<section class="products-hero {{ $category->hide_banner_content ? 'products-hero--image-only' : '' }}">
```

### Bước 7: Dọn admin panel
**File:** `resources/views/admin/settings/index.blade.php`

Xóa:
1. **Hai ô input chiều cao** (`banner_{key}_height_desktop` + `_mobile`) — xóa block `div` chứa 2 label+input
2. **Checkbox ẩn overlay** (`banner_{key}_hide_overlay`) — xóa thẻ `<label>` chứa checkbox
3. **Cập nhật message hướng dẫn** — đổi text từ "Mỗi trang có thể đặt chiều cao riêng..." → "Ảnh sẽ được crop tự động theo khung cố định. Hãy upload ảnh tỉ lệ ~2.6:1 để kết quả tốt nhất."

### Bước 8: Dọn BannerService
**File:** `app/Services/BannerService.php`

**Xóa:**
- `DEFAULT_HEIGHTS` constant (lines 33-44) — không còn dùng
- `sizes()` method (lines 49-59) — không còn dùng

**Giữ nguyên:** `BANNER_KEYS`, `get()`, `all()`, `resolveKey()`.

### Bước 9: Dọn AppServiceProvider
**File:** `app/Providers/AppServiceProvider.php`

**Xóa:**
```php
// XÓA cả block
View::composer('*', function ($view) {
    $view->with('siteBannerSizes', app(BannerService::class)->sizes());
});
```

### Bước 10: (Optional) Xóa setting cũ trong database
Tùy chọn — có thể chạy migration để xóa các row `banner_*_height_*` trong `settings` table. Không bắt buộc (sẽ bị ignore), nhưng giữ DB sạch.

---

## Thứ tự thực hiện để giảm rủi ro

```
1. Bước 1 (page-hero.css)          ← CSS mới, không phá gì
2. Bước 2 (products/hero.css)     ← CSS mới
3. Bước 3 (categories-hero.css)    ← File mới, fix bug đang có
4. Bước 4-5 (component + blades)  ← Thêm variant prop, không xóa gì
6. Bước 6 (xóa CSS vars)          ← Có thể rollback bằng git
7. Bước 7 (admin panel)           ← Có thể rollback bằng git
8. Bước 8-9 (BannerService + AppServiceProvider) ← Có thể rollback
9. Bước 10 (migration)            ← Optional
```

**Rollback:** Git revert từng bước. Nếu có vấn đề sau Bước 6, chỉ cần `git checkout` lại các blade đã sửa.

---

## Các file cần sửa

| File | Hành động |
|---|---|
| `public/css/page-hero.css` | Thêm height cố định + object-position |
| `public/css/products/hero.css` | Thêm height cố định + object-fit: cover |
| `public/css/categories-hero.css` | **File mới** — tạo rule cho `.categories-hero` |
| `app/Http/Controllers/Admin/SettingController.php` | Xóa logic xử lý height inputs (nếu có) |
| `resources/views/admin/settings/index.blade.php` | Xóa 2 ô height + checkbox overlay |
| `resources/views/components/page-hero.blade.php` | Xóa CSS vars + thêm prop `variant` |
| `resources/views/products/index.blade.php` | Xóa CSS vars, thêm `variant="products"` |
| `resources/views/categories/index.blade.php` | Xóa CSS vars |
| `resources/views/categories/show.blade.php` | Xóa CSS vars |
| `resources/views/cart/index.blade.php` | Thêm `variant="cart"` |
| `resources/views/checkout/index.blade.php` | Thêm `variant="checkout"` |
| `resources/views/blog/show.blade.php` | Thêm `variant="blog"` |
| `app/Services/BannerService.php` | Xóa `DEFAULT_HEIGHTS` + `sizes()` |
| `app/Providers/AppServiceProvider.php` | Xóa `siteBannerSizes` view composer |

---

## Các file KHÔNG sửa (giữ nguyên)

- `public/css/hero.css` — homepage editorial slider (padding-based)
- `public/css/seasonal.css` — seasonal `.shero`/`.shead`
- Inline `@push('styles')` trong policy/contact/guide pages
- `Category` model và `hide_banner_content` field (vẫn dùng)

---

## Verification

**Sau khi deploy:**
1. Mở `/san-pham` desktop → banner 400px cao
2. Mở `/san-pham` mobile 375px → banner 200px cao
3. Upload ảnh mới qua admin → crop đúng khung
4. Kiểm tra `/danh-muc` — hero đã có style (hiện đang hỏng)
5. Grep kiểm tra: `grep -r "siteBannerSizes\|banner-height-desktop" resources/views/` → phải trả 0 kết quả
6. Grep kiểm tra: `grep -r "height_desktop\|height_mobile" resources/views/admin/` → phải trả 0 kết quả
