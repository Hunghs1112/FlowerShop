# Audit banner hệ thống FlowerShop — 2025-10-14

Tổng hợp từ cuộc hội thoại rà soát banner các trang `lamnhienthao.com` và repo `D:\Github\FlowerShop`.

---

## Câu hỏi 1: Hệ thống banner đang tổ chức thế nào?

**Trả lời:** Repo dùng **5 kiểu banner song song**, mỗi kiểu tự viết CSS, tự chọn breakpoint, không có component chung:

| Hệ thống | Selector | Cơ chế height | Slider | Breakpoint mobile |
|---|---|---|---|---|
| Homepage prototype | `.hero` | padding clamp (auto) | ❌ | 980 / 560 |
| Page hero chung | `.page-hero` | padding token (auto) | ❌ | 1024 / 767 |
| Products hero | `.products-hero` | cố định qua CSS var inject | ❌ | 1024 / 767 |
| Editorial slider (cũ) | `.hero` | viewport 85vh/75vh/60vh/55vh | ✅ | 1024 / 640 / 380 |
| Seasonal | `.shero` `.shead` | padding clamp (auto) | ❌ | 980 / 560 |

**Vấn đề tổ chức:**
- Trùng tên selector `.hero` ở 2 hệ thống khác nhau.
- 3 pattern height khác nhau (viewport / padding-clamp / fixed-var).
- 3 set breakpoint khác nhau, không có lý do kỹ thuật.
- `public/css/hero.css` (460 dòng) — dead code, không view nào dùng slider.

---

## Câu hỏi 2: Review chi tiết hệ thống `products-hero`?

**Trả lời:** Tìm được **10 vấn đề** trong hệ thống này. Quan trọng nhất:

1. **`categories-hero` không có CSS** (chỉ có trong `products/hero.css` và `reference-pages.css`, không có file riêng). Trang `/danh-muc` render banner không style.
2. **`--banner-height-*` inject vô hiệu** — biến được inject nhưng `products/hero.css` không tham chiếu. Admin chỉnh height trong settings → không có tác dụng.
3. **`object-fit: contain` cho banner** — để lại 2 khoảng đen 2 bên với ảnh dọc.
4. **2 file Blade copy-paste** (`products/index.blade.php` + `categories/show.blade.php`) — cần tách component `<x-products-hero>`.
5. **3 breakpoint sets** cùng tồn tại cho cùng 1 component (1024/767 + override `reference-pages.css` không có mobile rule).
6. **Tablet 768–1023 không có rule riêng** — heading không co.
7. **Heading clamp max 6.8rem** trong `reference-pages.css` quá to.
8. **`products-hero--image-only` không dùng var height** — section cao = intrinsic img.
9. **Fallback ảnh hardcode** trong blade thay vì dùng `BannerService::get()`.
10. **Breadcrumbs render tay** ở 3 nơi (page-hero + 2 products blade).

**Đề xuất fix theo thứ tự:**
- Bước 1 (5 phút): tạo `public/css/categories-hero.css` mirror `products/hero.css`.
- Bước 2 (refactor): tạo `<x-products-hero>` component.
- Bước 3: sửa CSS root cause — `height: var(--banner-height-*)`, `object-fit: cover`.
- Bước 4: chuẩn hóa breakpoint mobile-first (≥768).
- Bước 5: dùng `BannerService::get('categories')` thay fallback tay.

---

## Câu hỏi 3: Xem kích thước ảnh thật trên production?

**Trả lời:** Probe trực tiếp `lamnhienthao.com` qua `curl` + `WebFetch`:

- **`home-hero.jpg` 404** — file default không tồn tại.
- **`danh-muc-hero.jpg` 404** — file default không tồn tại.
- **`products-1791802052-atUTUdek.jpg` 200** — intrinsic **2576×980 px**, ratio 2.629, 527 KB.

**Production CSS thật (`app.css?v=1791951550`):**
- `.categories-hero` count = **0** (xác nhận không có CSS).
- `.products-hero` count = 25, `.page-hero` count = 49.
- `--banner-height-*` trong `app.css`: **0 hits** (xác nhận var vô hiệu).

**Bảng render thực tế theo breakpoint** (ảnh 2576×980, ratio 2.629):

| Breakpoint | Khung | Tỉ lệ | Crop |
|---|---|---|---|
| Desktop 1280 | 400 px | 3.2 | crop ngang ~22% |
| Tablet 768 | 280 px | 2.74 | crop ngang ~4% |
| Mobile 375 | 200 px | 1.88 | crop dọc ~28% |

→ Đề xuất cập nhật `BannerService::DEFAULT_HEIGHTS` (mobile 280 → 200).

---

## Câu hỏi 4: Chạy Puppeteer đo bounding box thật?

**Trả lời:** Cài `puppeteer-core` + dùng `chrome.exe` có sẵn. Đo 3 viewport (375/768/1280) × 3 trang.

**Kết quả đo:**

| Trang | Selector | Desktop (w × h) | Nhận xét |
|---|---|---|---|
| `/san-pham` | `.page-hero--with-image` | 1280 × **488** | OK, ảnh cover fit gần hoàn hảo |
| `/danh-muc` | `.categories-hero` | 1280 × **134** | **Hỏng** — ảnh 404, heading 67px trên nền trắng |
| `/` | `.hero` | 1280 × **714** | Cao quá, `home-hero.jpg` 404 |
| `/` (mobile) | `.hero` | 375 × **1265** | **Quá cao** mobile, gãy layout |

**6 bug xác nhận trên production:**
1. `categories-hero` không CSS.
2. `--banner-height-*` inject vô hiệu.
3. `home-hero.jpg` + `danh-muc-hero.jpg` 404.
4. `/san-pham` production dùng `.page-hero` (khác repo).
5. Mobile height 280 → crop 50% với ảnh ratio 2.63.
6. Mobile home 1265px (gấp đôi desktop) do 2-cột grid 1 cột chồng.

---

## Câu hỏi 5: Trang nào không cần hero nữa?

**Trả lời:** Đo production 22 trang. Bảng phân loại:

| Trang | Trạng thái | Đề xuất |
|---|---|---|
| `/` | Có hero (hỏng) | Giữ + sửa |
| `/san-pham` | Có hero | Giữ |
| `/danh-muc` | Có hero (hỏng) | Giữ + sửa |
| `/danh-muc/[slug]` | Có hero | Giữ |
| `/gio-hang` | Có hero (488px) | ⚠️ Bỏ |
| `/bai-viet` | Không hero | Đã bỏ |
| `/bai-viet/[slug]` | Có (theo blade) | Giữ |
| `/san-pham/[slug]` | `.tree-product-detail` (không phải hero) | Đúng |
| `/b2c` | Có hero (585px) | Giữ |
| `/huong-dan-dat-hang` | Có hero (689px) | ⚠️ Có thể bỏ |
| `/lien-he` | Có hero (553px) | ⚠️ Có thể bỏ |
| `/chinh-sach-giao-hang` | Có hero (498px) | **Giữ** (artwork tích hợp) |
| `/chinh-sach-bao-mat` | Có hero (579px) | **Giữ** (artwork tích hợp) |
| `/chinh-sach-cua-chung-toi` | Có hero (490px) | **Giữ** (artwork tích hợp) |
| `/dieu-khoan-dich-vu` | Có hero (theo blade) | **Giữ** (artwork tích hợp) |
| `/gioi-thieu` | `.about` (custom block) | Giữ |
| `/mua-le-hoi` (3 trang) | `.shead`/`.shero` | Giữ |
| `/yeu-thich`, `/thanh-toan`, `/hop-hoa-bi-an`, `/login` | Không hero | Đúng |

**Kết luận:** Admin đã bỏ hero ở blog/favorites/checkout/login nhưng dừng giữa chừng — còn sót 3 trang có thể bỏ (`/gio-hang`, `/huong-dan-dat-hang`, `/lien-he`). 4 trang policy **giữ nguyên** theo quyết định của user.

---

## Câu hỏi 6: Trang nào hiển thị ảnh banner, trang nào không — xem thực tế?

**Trả lời:** Probe bằng Puppeteer (chặn network requests + đo DOM render).

**22 trang production — 11 có hero. Phân loại:**

### ✅ Hoạt động tốt (9 trang)
- `/san-pham` — `products-1791802052-atUTUdek.jpg` (2576×980) → 1280×488
- `/danh-muc/[slug]` — `categories/1791815906-jfJ7TwxW.jpg` (2576×980) → 1280×614
- `/b2c` — `b2c-1791801630-cKkJGXJQ.jpg` (2576×980) → 1280×585
- 3 trang seasonal — ảnh `seasonal_hero_*` (1440×1440 → 1800) → 440×537
- `/bai-viet`, `/login`, `/thanh-toan`, `/yeu-thich`, `/hop-hoa-bi-an` — không hero (đúng)

### 🔴 404 / broken (2 trang)
- `/` — `home-hero.jpg` 404 (admin fix tạm bằng ảnh sản phẩm 1440×1800)
- `/danh-muc` — `danh-muc-hero.jpg` 404, render 1280×26 (ảnh 0×0)

### ⚠️ Kỳ lạ / lãng phí (5 trang)
- **`/gio-hang`** — `cart-1791124691-Wd2Hva8Q.jpg` (3417×1300) bị crop 38% vì khung 488px quá thấp
- **`/lien-he`** — `contact-1791123963-kogJTBnp.jpg` 3417×1300 nhưng chỉ render 170×170 (icon) — **lãng phí 685KB bandwidth**
- **`/chinh-sach-giao-hang`** — `policy-delivery-bouquet.jpg` 300×300 chỉ làm icon 160×160
- **`/chinh-sach-bao-mat`** — hero trống, chỉ có logo (blade không truyền ảnh)
- **`/chinh-sach-cua-chung-toi`** — `policy-ours-bloom.jpg` 380×380 chỉ làm icon 170×170
- **`/phu-kien-cay-thong`** — dùng chung ảnh với `/mua-le-hoi/cay-thong-dan-mach`

**Đề xuất fix:**
1. Upload 2 ảnh default đang 404 (`home-hero.jpg`, `danh-muc-hero.jpg` 2576×980).
2. Nén ảnh `cart-...` (3417×1300 → 2576×980, tiết kiệm ~450KB/lượt).
3. Nén ảnh `contact-...` (3417×1300 → 380×380, tiết kiệm ~685KB/lượt).
4. Bỏ 4 ảnh decoration trong hero policy/guide (chỉ làm icon).
5. Đổi ảnh "phụ kiện cây thông" (đang trùng với "cây thông Đan Mạch").

**Tổng bandwidth tiết kiệm:** ~1.3KB/lượt tải nếu làm hết.

---

## Câu hỏi 7: Bỏ hero ở các trang policy như thế nào?

**Trả lời:** User xác nhận **GIỮ NGUYÊN hero 4 trang policy** (`/chinh-sach-giao-hang`, `/chinh-sach-cua-chung-toi`, `/dieu-khoan-dich-vu`, `/chinh-sach-bao-mat`) — không cần bỏ. Lý do: mỗi trang có artwork riêng (visa / board / pass / tracker) làm phần trang trí tích hợp, bỏ `.hero` sẽ mất luôn phần này.

→ Cập nhật audit: **không sửa 4 trang policy**. Loại khỏi danh sách đề xuất bỏ.

**Danh sách đề xuất bỏ hero sau khi điều chỉnh:**
- ~~`/chinh-sach-giao-hang`~~ — giữ
- ~~`/chinh-sach-cua-chung-toi`~~ — giữ
- ~~`/dieu-khoan-dich-vu`~~ — giữ
- ~~`/chinh-sach-bao-mat`~~ — giữ

Còn lại (vẫn đề xuất bỏ):
- `/gio-hang` — chỉ là "Giỏ hàng" + breadcrumb, không có giá trị conversion
- `/huong-dan-dat-hang` — text-heavy, hero 689px chiếm ~85% viewport đầu
- `/lien-he` — text-heavy, hero 553px tương tự

Có thể cân nhắc thêm với user trước khi sửa.

---

## Tóm tắt 1 câu

> Repo FlowerShop có **5 hệ thống banner song song** không có component chung, ảnh 2 default 404 trên production, biến `--banner-height-*` inject vô hiệu, 4 trang policy có hero tích hợp artwork (giữ nguyên theo user), còn 3 trang `/gio-hang`, `/huong-dan-dat-hang`, `/lien-he` lãng phí ~2000px chiều cao mobile — đề xuất bỏ ở 3 trang này, sửa `categories-hero` (thiếu CSS), upload 2 ảnh default 404, nén 2 ảnh banner quá lớn.
