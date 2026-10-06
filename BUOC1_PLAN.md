# BƯỚC 1 — PHÂN TÍCH & KẾ HOẠCH TRIỂN KHAI ĐỢT 1

## 1. MAPPING HTML NGUỒN → LARAVEL

### Đợt 1: Các trang cần cập nhật

| HTML nguồn | Route hiện có | Blade hiện có | Controller/Model | Cần tạo/sửa |
|---|---|---|---|---|
| `chinh-sach-bao-mat.html` | `GET /trang/{slug}` | `pages/policy.blade.php` | `PageController::policy` / `Page` | **Sửa** Blade + CSS để khớp HTML nguồn |
| `chinh-sach-cua-chung-toi.html` | `GET /trang/{slug}` | `pages/policy.blade.php` | `PageController::policy` / `Page` | **Sửa** Blade + CSS |
| `chinh-sach-giao-hang.html` | `GET /trang/{slug}` | `pages/policy.blade.php` | `PageController::policy` / `Page` | **Sửa** Blade + CSS |
| `dieu-khoan-dich-vu.html` | `GET /trang/{slug}` | `pages/policy.blade.php` | `PageController::policy` / `Page` | **Sửa** Blade + CSS |
| `huong-dan-dat-hang.html` | — | — | — | **Tạo** route + controller + Blade mới |
| `lien-he.html` | `GET/POST /lien-he` | `pages/contact.blade.php` | `PageController::contact/contactSubmit` / `Inquiry` | **Sửa** Blade + CSS để khớp HTML nguồn |
| `ve-chung-toi.html` | `GET /ve-chung-toi` | `pages/about.blade.php` | `PageController::about` / `Page` + `FlowerOrigin` | **Sửa** Blade + CSS + JS |

### Đợt 2: Không có route mới

| HTML nguồn | Route hiện có | Blade hiện có | Controller/Model | Cần tạo/sửa |
|---|---|---|---|---|
| `hop-hoa-bi-an.html` | `GET /hop-hoa-bi-an` | `mystery-box/index.blade.php` | `MysteryBoxController` / `MysteryBoxRequest` | **Sửa** Blade (cập nhật SVG 8 objects + interaction JS) |

### Đợt 3: Chưa phân tích (chờ xác nhận)

---

## 2. FILE SẼ SỬA ĐỢT 1 — CHÍNH XÁC

### Tạo mới

1. **`routes/web.php`** — Thêm route cho `huong-dan-dat-hang`:
   ```php
   Route::get('/huong-dan-dat-hang', [PageController::class, 'guide'])->name('guide');
   Route::get('/trang/huong-dan-dat-hang', [PageController::class, 'guide']);
   ```

2. **`app/Http/Controllers/PageController.php`** — Thêm method `guide()`

3. **`resources/views/pages/guide.blade.php`** — Tạo mới từ HTML nguồn

4. **`public/css/guide.css`** — Tạo mới (CSS từ inline HTML nguồn, scoped `.page-guide`)

5. **`public/js/guide.js`** — Tạo mới nếu cần (JavaScript từ inline HTML nguồn)

### Sửa

| File | Mục đích sửa |
|---|---|
| `resources/views/pages/policy.blade.php` | Cập nhật layout HTML để khớp `chinh-sach-*.html` nguồn |
| `resources/views/pages/contact.blade.php` | Cập nhật layout để khớp `lien-he.html` nguồn |
| `resources/views/pages/about.blade.php` | Cập nhật layout để khớp `ve-chung-toi.html` nguồn (passport stamps, map, cards) |
| `public/css/pages.css` | Bổ sung CSS scoped cho policy/contact/about/guide pages |
| `public/css/about-atlas.css` | Cập nhật để khớp `ve-chung-toi.html` nguồn (map interaction) |
| `public/css/contact.css` | Cập nhật để khớp `lien-he.html` nguồn |
| `public/js/about-map.js` | Cập nhật để khớp `ve-chung-toi.html` nguồn (map pins, cards) |

---

## 3. BẢNG MAPPING MÀU HTML NGUỒN → TOKEN THEME

| Token HTML nguồn | Giá trị | Token theme Laravel thay thế | Ghi chú |
|---|---|---|---|
| `--bg` / `#F5EBE6` | Warm cream background | `--color-cream` `#F5EBE6` | ✓ Khớp |
| `--paper` / `#FCF8F5` | Warm white card | `--color-cream-dark` `#FCF8F5` | ✓ Khớp |
| `--ink` / `#5E4636` | Warm brown text | `--color-text` `#5E4636` | ✓ Khớp |
| `--soft` / `#8C6E5C` | Muted warm brown | `--color-text-light` `#8C6E5C` | ✓ Khớp |
| `--copper` / `#C78E66` | Copper accent (primary) | `--color-primary` `#C78E66` | ✓ Khớp |
| `--deep` / `#A8714E` | Deep copper/rose | `--color-secondary` `#A8714E` | ✓ Khớp |
| `--line` / `#E6D3C6` | Warm border/line | `--color-border` `#E6D3C6` | ✓ Khớp |
| `--dark` / `#2B201B` | Dark board background | **CẦN THÊM** `--color-board` | Dùng trong contact/about |
| `--shadow` | Shadow rgba | `--shadow-sm` hoặc custom rgba | Map theo `--color-primary` |
| `--board` / `#3A2C24` | Dark board (dark theme) | `--color-board` `#3A2C24` | ✓ Hiện có trong theme |
| `--tile` / `#241B16` | Dark tile | — | Dark mode variant |
| `--tile-ink` / `#F4E8DC` | Light text on dark | `--color-text-light` hoặc `--color-white` | |
| `--tile-acc` / `#E2AE84` | Accent on dark | `--color-primary-light` `#E2AE84` | |
| `#EADBCF` | Warm tan (stage bg) | `color-mix(in srgb, var(--color-primary) 20%, var(--color-cream))` | Rough approximation |
| `#9AA07A` | Sage green | **CẦN THÊM** `--color-sage` | Dùng nhiều trong SVG |
| `#7E8A52` | Dark botanical green | **CẦN THÊM** `--color-botanical` | |
| `#A97E5E` | Warm wood brown | `--color-primary` nhưng cần nhạt hơn | Cần thêm `--color-primary-lighter` |
| `#E6B8B0` | Dusty rose | **CẦN THÊM** `--color-rose` | Dùng trong SVG flowers |
| `#B5776A` | Terracotta | **CẦN THÊM** `--color-terracotta` | |
| `#C98E66` | Copper variant | `--color-primary` | |
| `#D9A85E` | Gold/key color | **CẦN THÊM** `--color-gold` | Dùng trong mystery-box |
| `#B04A3A` | Error red | `--color-error` `#A6534E` | |

### ACTION ITEMS cho mapping màu:

**Cần xác nhận trước khi code:**
1. Thêm `--color-board: #3A2C24` vào `theme.css` (hiện đã có nhưng cần confirm)
2. Thêm `--color-sage: #9AA07A` vào `theme.css`
3. Thêm `--color-botanical: #7E8A52` vào `theme.css`
4. Thêm `--color-terracotta: #B5776A` vào `theme.css`
5. Thêm `--color-gold: #D9A85E` vào `theme.css`
6. `--color-sage` hiện là `#E6D3C6` (từ theme.css line 28) — cần OVERRIDE = `#9AA07A` cho các trang này
7. `--color-primary-light` hiện là `#E2AE84` — gần với `#C78E66` nhưng cần xác nhận dùng trong SVG rooms

---

## 4. PHÂN TÍCH TỪNG HTML NGUỒN

### 4.1 `chinh-sach-bao-mat.html` / `chinh-sach-cua-chung-toi.html` / `chinh-sach-giao-hang.html` / `dieu-khoan-dich-vu.html`

**Nội dung:**
- Dữ liệu demo: ❌ **Toàn bộ nội dung từ database** — trang hiện dùng `Page` model
- Static content: ✓ Các trang policy có thêm content sections (địa chỉ công ty, hotline, form) cần đối chiếu
- **Vấn đề tương thích backend:**
  - HTML nguồn có form điền thông tin (khác biệt) — trong Laravel, trang policy chỉ hiển thị nội dung Page từ DB
  - HTML nguồn `chinh-sach-bao-mat.html` có section "Liên hệ với LNT" với hotline/email
  - **Cần giữ nguyên logic Blade hiện có**, chỉ cập nhật CSS/layout
- **Cần chuyển thành Blade data:** Nội dung chính sách từ `Page::where('slug', $slug)->first()` — đã có ✓
- **Giữ nguyên:** Layout `@extends('layouts.app')` + `@section('content')` — đã có ✓

**Điểm cần cập nhật:**
- Header section trong HTML nguồn khác với Blade hiện tại (HTML có breadcrumb + title + lead text từ page data)
- CSS class `.policy-page` / `.page-policy` — cần thêm
- Footer của trang policy (HTML nguồn không có navbar/footer, chỉ có nội dung chính)

### 4.2 `huong-dan-dat-hang.html` — TRANG MỚI CẦN TẠO

**Nội dung:**
- Dữ liệu demo: ✓ Static content, không cần backend
- Static content: ✓ Toàn bộ là HTML/CSS tĩnh (5 bước ordering guide)
- Không tương thích backend: ✓ Tất cả nội dung static
- Cần chuyển thành Blade data: ❌ Không cần
- Giữ nguyên: ❌ Trang mới hoàn toàn

**Layout chính:**
- Hero section với logo + eyebrow + h1 + lead text + visual itinerary
- `details/summary` accordion cho 5 chặng: Check-in, Hành lý, Thanh toán, Khai báo, Hạ cánh
- Help section với Zalo/email/phone CTAs
- Footer

**CSS components:** `gates` (accordion), `visual`/`itin` (itinerary), `cards`, `help`, `foot`

### 4.3 `lien-he.html`

**Nội dung:**
- Dữ liệu demo: ✓ Static content (Zalo, hotline, email, địa chỉ)
- Static content: ✓ Tất cả static, ngoại trừ form submit → `PageController::contactSubmit`
- Không tương thích backend: ✓ Form action giữ nguyên `POST /lien-he` → `contactSubmit`
- Cần chuyển thành Blade data: ❌ Không cần (form data = user input)
- Giữ nguyên: ✓ `routes/web.php` `POST /lien-he` → `PageController::contactSubmit` — đã có ✓

**Điểm cần cập nhật:**
- Layout hero trong HTML nguồn: logo + eyebrow + h1 + lead text + breadcrumb
- Map/address section với thông tin liên hệ
- Form với các field: Họ tên, Email, Số điện thoại, Nội dung (hiện có trong Blade)
- Zalo/phone CTA buttons

### 4.4 `ve-chung-toi.html` — PHỨC TẠP NHẤT

**Nội dung:**
- Dữ liệu demo: ✓ Static content (passport stamps, map pins dùng dữ liệu tĩnh)
- Static content: ✓ Tất cả static
- Không tương thích backend: ✓
- Cần chuyển thành Blade data: ❌ Không cần
- Giữ nguyên: ❌ Trang about hiện có cần được thay thế hoàn toàn

**Layout chính:**
1. Hero: logo + h1 "Về chúng tôi" + tagline + map (SVG interactive với pins)
2. Map SVG với 9 pins (Hà Nội, Huế, TP.HCM, v.v.) — click hiện card
3. Team cards dạng passport với ảnh + tên + vai trò + năm gia nhập
4. Loyalty passport: 9 stamp nhấp để collect → hiện mã giảm giá
5. Stats: số năm hoạt động, số đơn, số khách hàng
6. Flower Atlas section: ảnh hoa có thể nhấp để xem chi tiết

**JavaScript interactions:**
- `about-map.js`: Map pin click → show/hide card, home pin animation
- Passport stamp: click stamp → animate pop → reveal reward
- Stamp collection: localStorage để nhớ stamps đã collect

**CSS components:** `.map-wrap`, `.land`, `.arc`, `.pin`, `.home`, `.card`, `.chips`, `.stats`, `.passport`, `.pp-grid`, `.st`

---

## 5. KẾ HOẠCH CSS

### File CSS cần tạo

| File | Page scope | Mô tả |
|---|---|---|
| `public/css/guide.css` | `.page-guide` | Từ inline `<style>` trong `huong-dan-dat-hang.html` — itinerary layout, accordion gates, help section |

### File CSS cần sửa

| File | Mục sửa |
|---|---|
| `public/css/pages.css` | Thêm `.page-policy` scoped styles cho các trang chính sách |
| `public/css/contact.css` | Thêm `.page-contact` scoped — hero layout, map section, form styles |
| `public/css/about-atlas.css` | Thêm `.page-about` scoped — map, cards, passport, stats |

### Selector scope

```
.page-policy     → resources/views/pages/policy.blade.php
.page-contact   → resources/views/pages/contact.blade.php
.page-about     → resources/views/pages/about.blade.php
.page-guide     → resources/views/pages/guide.blade.php (mới)
```

---

## 6. KẾ HOẠCH JAVASCRIPT

### File JS cần tạo

| File | Mục đích |
|---|---|
| `public/js/guide.js` | Accordion toggle, itinerary leg click — từ inline `<script>` trong `huong-dan-dat-hang.html` (rất nhỏ, có thể gộp vào Blade inline) |

### File JS cần sửa

| File | Mục sửa |
|---|---|
| `public/js/about-map.js` | Cần đối chiếu với SVG trong `ve-chung-toi.html` — pins array, home pin animation, card swap |

**Lưu ý về `about-map.js`:**
- HTML nguồn có pins ở vị trí khác (9 pins: Hà Nội, Huế, Đà Nẵng, TP.HCM, Nha Trang, v.v.)
- Pin `home` (Hà Nội) có animation `pulse` + `ring`
- Cards swap với `swap` animation khi click pin
- Cần kiểm tra xem JS hiện tại có khớp không

---

## 7. DIFF NHỎ NHẤT ĐỢT 1

### Chi phí ước tính

| Thành phần | File | Chi phí |
|---|---|---|
| Route + Controller | 2 file | Thấp |
| Blade pages (sửa 3, tạo 1) | 4 file | Trung bình |
| CSS (sửa 3, tạo 1) | 4 file | Trung bình |
| JS about-map.js | 1 file | Thấp |
| **Tổng** | **~10 file** | — |

### Thứ tự ưu tiên triển khai

1. `huong-dan-dat-hang.html` → route + PageController + guide.blade.php + guide.css (độc lập, ít rủi ro)
2. `chinh-sach-*.html` → cập nhật policy.blade.php + pages.css
3. `lien-he.html` → cập nhật contact.blade.php + contact.css
4. `ve-chung-toi.html` → cập nhật about.blade.php + about-atlas.css + about-map.js (phức tạp nhất)

---

## 8. TIÊU CHÍ NGHIỆM THU

### Desktop (≥1024px)
- [ ] Trang chính sách: nội dung Page hiển thị đúng, breadcrumb, title, CSS theme khớp HTML nguồn
- [ ] Trang hướng dẫn đặt hàng: itinerary visual đẹp, 5 accordion mở/đóng đúng, CTAs hoạt động
- [ ] Trang liên hệ: map/address section đúng, form submit vào `PageController::contactSubmit`
- [ ] Trang về chúng tôi: SVG map interactive (9 pins), team passport cards, loyalty stamps (click → pop → reward)

### Mobile (≤768px)
- [ ] Navbar responsive đúng
- [ ] Accordion/itinerafy xếp dọc đúng
- [ ] Passport stamps grid responsive
- [ ] Form inputs touch-friendly

### Backend/Functional
- [ ] `POST /lien-he` → form submit lưu vào `Inquiry` table
- [ ] Page slug routing hoạt động cho 4 trang policy
- [ ] Auth middleware mystery-box không bị ảnh hưởng
- [ ] Navbar/footer Laravel dùng chung không bị trùng lặp

### Visual
- [ ] Màu sắc khớp bảng mapping đã duyệt
- [ ] Font (Josefin Sans, Lora) đúng
- [ ] Animation/transition hover/focus giữ nguyên
- [ ] Spacing/typography khớp HTML nguồn

---

## 9. OPEN QUESTIONS — CẦN XÁC NHẬN

### XÁC NHẬN (2025-XX-XX)

| # | Câu hỏi | Quyết định |
|---|---|---|
| 1 | Token `--color-sage` conflict | ✅ Dùng `--color-sage-green` mới |
| 2 | Passport stamps | ✅ Giữ static như HTML nguồn |
| 3 | Vietnam pins map data | ✅ Dùng Blade data array |
| 4 | Guide itinerary animation | ✅ Giữ animation `fly` |

---

*Báo cáo này tuân thủ đầy đủ nguyên tắc A–J. Đã xác nhận — sẵn sàng Bước 2.*
