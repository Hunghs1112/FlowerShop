# Prompt thiết kế UI — FlowerShop (Layout Only)

---

## Design System

```
Background:     #FAF8F3  (ivory), #FFFFFF
Primary:        #1F2420
Secondary:      #6F716C
Border:         #E2DED5
Accent:         muted sage green / dusty rose (dùng tiết chế)

Typography:     Inter / Manrope / DM Sans
Heading weight: 600–700
Body weight:    400

Border radius:  Image 20–24px, Button 999px
Section pad:    90–120px desktop, 55–70px mobile
Container max:  1280–1320px
Gap:            20–24px (grid)

Interaction:    hover 250–400ms, scale max 1.03–1.05
Animation:      fade/translate nhẹ, respects prefers-reduced-motion
```

---

## 1. Navbar + Dropdown

### Navbar Layout

```
LOGO | Trang chủ | Sản phẩm ▾ | Góc cảm hứng ▾ | Dịch vụ ▾ | Về chúng tôi | Liên hệ |  🔍  ♡  ♙  🛒
```

- White background, sticky, border-bottom 1px nhẹ
- Logo trái, nav links giữa, icons phải
- Nav item hover: text color accent + border-bottom 2px accent
- Mobile: logo + hamburger + icons phải

### Sản phẩm — Mega Menu (4 cột + 1 image)

```
┌─────────────────────────────────────────────────────────────────┐
│  LOẠI HOA       PHONG CÁCH        DỊP TẶNG       KHÁM PHÁ    │
│  Hoa hồng       Bó hoa            Sinh nhật      Hoa mới về  │
│  Hoa tulip      Hộp hoa           Kỷ niệm        Bán chạy    │
│  Hoa mẫu đơn    Hoa cắm bình      Tình yêu       Hoa theo mùa│
│  Cẩm tú cầu    Hoa tối giản      Chúc mừng      Nhập khẩu   │
│  Hoa ly         Hoa pastel        Khai trương     Quà tặng     │
│  Hoa baby       Hoa cưới          Cảm ơn         Khuyến mãi  │
│                                                                  │
│                                        ┌─────────────────┐      │
│                                        │                 │      │
│                                        │   ẢNH HOA       │      │
│                                        │   BST mới →     │      │
│                                        └─────────────────┘      │
└─────────────────────────────────────────────────────────────────┘
```

- Width 100%, max 1280px, căn giữa
- Background white, border-top 1px nhẹ, shadow mềm
- Padding 32–38px
- Animation: opacity 0→1 + translateY(-5px→0), 200–250ms
- Link hover: color accent + translateX(3px)
- Hover nav → mở menu, click outside / ESC → đóng

### Các dropdown còn lại

```
Góc cảm hứng ▾        Dịch vụ ▾              Liên hệ ▾
┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│ Chăm sóc hoa │     │ Giới thiệu   │     │ Thông tin    │
│ Ý nghĩa hoa  │     │ Hệ thống cửa │     │ Liên hệ      │
│ Giữ hoa tươi│     │ Dịch vụ đặt  │     │ Đặt theo yêu │
│ Nghệ thuật  │     │ Giao hoa     │     │ FAQ          │
│ Xu hướng    │     │ Ưu đãi       │     │              │
│ Câu chuyện  │     └──────────────┘     │ Hotline      │
└──────────────┘                          │ 0909 999 999 │
                                          └──────────────┘
```

- Width 220–250px, background white, border-radius 0 0 14px 14px
- Shadow nhẹ, padding 10–12px
- Link hover: background #F7F5F0, border-radius 8px

### Mobile Nav

```
[LOGO]                    [🔍] [🛒] [☰]
─────────────────────────────────────
Trang chủ
Sản phẩm          +
  Hoa hồng
  Hoa tulip
  ...
Góc cảm hứng      +
Dịch vụ           +
Về chúng tôi
Liên hệ
```

- Full-width drawer, accordion animation nhẹ
- Accordion expand/collapse khi click

---

## 2. Homepage Sections

### Section 1 — Hero
- Full-viewport height, ảnh toàn màn hình
- Overlay gradient nhẹ (đen 10–20% opacity)
- Text nội dung ở giữa hoặc bên trái
- Slideshow: phần text/slider nằm overlay bên trên ảnh
- Slide indicators dạng dots nhỏ phía dưới

### Section 2 — Sản phẩm bán chạy
- Section heading + subheading căn giữa
- Grid 4 cột (desktop), 3 (tablet), 2 (mobile)
- Product card không có background riêng

**Product card — Normal state:**
```
┌──────────────────┐
│                  │
│   ẢNH HOA       │  ← aspect ~1/1.1, border-radius 20–24px
│                  │
│  -20%   ♡       │  ← badge góc trái, wishlist góc phải
└──────────────────┘
 Bó hoa             ← pill tag, border 1px, border-radius 999px
 Bó hoa hồng pastel
 680.000đ           ← weight 600–700
 850.000đ           ← line-through, color #999
```

**Product card — Hover state:**
```
- Image: scale(1.03), overflow hidden trên container
- Overlay nhẹ xuất hiện
- "Xem chi tiết" button fade in từ dưới (translateY(8px)→0, opacity 0→1)
- Wishlist icon: background white, visible
- Card height không thay đổi
```

### Section 3 — Khám phá danh mục

```
┌────────────────────┬──────────────────────────────┐
│                    │  KHÁM PHÁ HOA               │
│  ┌──────┐┌──────┐ │  Khám phá danh mục           │
│  │ ẢNH  ││ ẢNH  │ │  ╰──                       │
│  │ HOA  ││ HOA  │ │                              │
│  └──────┘└──────┘ │  Hoa tươi               →  │
│   HOA HỒNG  HOA NHẬP│  Hoa nhập khẩu         →  │
│                    │  Bó hoa                 →  │
│                    │  Hộp hoa                 →  │
│                    │  Hoa cưới                →  │
│                    │  Hoa theo mùa            →  │
└────────────────────┴──────────────────────────────┘
```

- 2 image cards bên trái: aspect 3/4–4/5, border-radius 20–24px, gap 20px
- Gradient overlay nhẹ ở đáy ảnh, text trắng
- Category list bên phải: 70–78px mỗi item, border-top 1px #DDD9D0
- Arrow circle: 44px, border 1px, icon arrow outline
- Hover: text → accent color, arrow circle → background accent, icon → trắng, translateX(4px)

### Section 4 — Giá trị thương hiệu

```
┌─────────────┬─────────────┬─────────────┐
│     🌸      │     🎁      │     🌿      │
│             │             │             │
│  Heading    │  Heading    │  Heading    │
│  Description│  Description│  Description│
└─────────────┴─────────────┴─────────────┘
```

- Background #FAF8F3, 3 columns căn đều
- Icon: line icon 40–48px, stroke 1.5–2px, đặt trong circle border 1px (58px)
- Heading: 20–22px, weight 600, text-align center
- Description: 14–16px, line-height 1.6, color #666
- Section padding 90–110px top/bottom
- fade-up animation khi scroll vào (500–700ms)

### Section 5 — Nhà vườn & Đối tác

```
           Những nhà vườn
          chúng tôi tin tưởng

Đồng hành cùng những nhà vườn và đối tác uy tín...

[Logo 1] [Logo 2] [Logo 3] [Logo 4] [Logo 5]
```

- Heading 48–56px, căn giữa, description width ~600px
- Logo: monochrome, opacity 60–70%
- Hover: opacity 100%, transition 300ms
- Mobile: horizontal marquee/carousel

### Section 6 — Cảm hứng từ hoa (Blog)

```
         GÓC NHỎ CỦA CHÚNG TÔI
         Cảm hứng từ những mùa hoa

┌────────┐ ┌────────┐ ┌────────┐ ┌────────┐
│        │ │        │ │        │ │        │
│  ẢNH   │ │  ẢNH   │ │  ẢNH   │ │  ẢNH   │  ← aspect 4:5, radius 20–24px
│        │ │        │ │        │ │        │
│ Chăm   │ │ Hoa    │ │ Cảm    │ │ Kiến   │
│ hoa    │ │ theo   │ │ hứng   │ │ thức   │
│        │ │ mùa    │ │        │ │        │
│ Title  │ │ Title  │ │ Title  │ │ Title  │
│ Desc   │ │ Desc   │ │ Desc   │ │ Desc   │
│ Read → │ │ Read → │ │ Read → │ │ Read → │
└────────┘ └────────┘ └────────┘ └────────┘

              [ Xem tất cả bài viết → ]
```

- 4 cards/row desktop, 2–3 tablet, 1–2 mobile
- Image aspect 4:5, border-radius 20–24px, object-fit cover
- Category pill: border 1px, border-radius 999px
- Card: no background, no shadow, no border
- Hover: image scale(1.03), title → accent, arrow translateX(4px)
- 300–400ms transition

### Section 7 — Instagram Gallery

```
        Fello trên Instagram
        @ten_thuong_hieu

        Khám phá những bó hoa mới...

┌────┐ ┌────┐ ┌────┐ ┌────┐ ┌────┐
│    │ │    │ │    │ │    │ │    │
│ Ảnh│ │ Ảnh│ │ Ảnh│ │ Ảnh│ │ Ảnh│  ← 1:1, radius 18–22px, gap 18–22px
│    │ │    │ │    │ │    │ │    │
└────┘ └────┘ └────┘ └────┘ └────┘
Hover: overlay nhẹ + Instagram icon ở giữa + scale(1.03)

           [ Theo dõi Instagram → ]
```

- 5 images/row desktop, 2/row mobile hoặc carousel
- Hover: overlay rất nhẹ, icon Instagram ở giữa, scale(1.03)
- CTA button dưới cùng

### Section 8 — Footer

```
┌──────────────┬──────────────┬──────────────┬──────────────┐
│   Liên hệ   │  Mua sắm     │   Hỗ trợ    │  Newsletter  │
│              │              │              │              │
│ Hotline      │ Hoa tươi     │ Về chúng tôi│ Nhận cảm    │
│ 0909 999 999 │ Hoa nhập khẩu│ Hướng dẫn   │ hứng từ hoa  │
│ Email        │ Bó hoa       │ Chính sách  │              │
│ hello@...    │ Hộp hoa      │ giao hàng   │ [Email...]   │
│ Địa chỉ     │ Hoa cưới     │ Đổi trả     │ [Đăng ký]   │
│              │ Hoa theo mùa │ Liên hệ     │              │
│ [IG][FB]     │ Quà tặng     │              │ Consent text │
│ [TT][YT]     │              │              │              │
└──────────────┴──────────────┴──────────────┴──────────────┘

© 2026 Fello. All rights reserved.  |  Chính sách  Điều khoản  Cookies
[Visa] [Mastercard] [VNPay] [MoMo] [ZaloPay]
```

- Background #F8F6F0, border-top 1px #E5E1D8
- Social icons: circle border 1px, 42–46px, hover → background accent, icon trắng
- Newsletter: input + button cùng height (54–58px), border-radius 999px
- Bottom: divider + © + policy links + payment logos (grayscale, nhỏ)
- Mobile: accordion columns, newsletter đặt đầu hoặc cuối

---

## 3. Trang Sản phẩm (Products Page)

### Hero Banner

```
┌────────────────────────────────────────────────────┐
│                                                    │
│  Trang chủ / Sản phẩm                              │
│                                                    │
│              TẤT CẢ SẢN PHẨM                       │
│       Khám phá những bó hoa tươi được...          │
│                                                    │
└────────────────────────────────────────────────────┘
```

- Height 480–560px, ảnh full-width, overlay nhẹ
- Heading 56–72px, weight 600–700, letter-spacing -2px
- Description 17–18px, width max 600px

### Toolbar

```
[ 🔍 Lọc ]   Hiển thị 24 sản phẩm          [ Sắp xếp: Mặc định ▾ ]
```

- Filter button: border 1px, border-radius 999px, height 40px
- Sort dropdown: width ~220px, border-radius 999px

### Filter Sidebar

```
┌─────────────────────┐
│  Lọc sản phẩm    ✕  │
│─────────────────────│
│  Tìm kiếm           │
│  [_______________]  │
│                     │
│  Danh mục           │
│  ○ Hoa hồng   (12) │
│  ○ Hoa tulip  (8)  │
│  ○ Bó hoa     (15) │
│  ○ Hộp hoa    (10) │
│                     │
│  Khoảng giá         │
│  ○ Dưới 500K       │
│  ○ 500K–1M         │
│  ○ 1M–2M           │
│  ○ Trên 2M         │
│                     │
│  Tình trạng         │
│  □ Chỉ còn hàng    │
│                     │
│─────────────────────│
│  [Đặt lại] [Áp dụng]│
└─────────────────────┘
```

- Desktop: sidebar từ trái (width ~280px), overlay phía sau
- Mobile: drawer từ dưới hoặc full-width modal
- Checkbox minimal, heading weight 600

### Product Grid

```
┌────────┐ ┌────────┐ ┌────────┐ ┌────────┐
│        │ │        │ │        │ │        │
│  ẢNH   │ │  ẢNH   │ │  ẢNH   │ │  ẢNH   │  ← aspect ~1/1.05, radius 20–24px
│        │ │        │ │        │ │        │
│ -20% ♡│ │     ♡  │ │ -15%♡ │ │     ♡  │
└────────┘ └────────┘ └────────┘ └────────┘
 Bó hoa   Hộp hoa   Hoa tulip Hoa mẫu đơn
 Tên sp   Tên sp    Tên sp    Tên sp
 Giá      Giá       Giá       Giá
 Gạch giá Gạch giá  Gạch giá
```

- 4 columns desktop, 3 tablet, 2 mobile
- Badge: background accent/đỏ, text trắng, border-radius 999px
- Hover: image scale(1.03), "Xem chi tiết" button fade in

### Pagination

```
←  1  2  3  ...  8  →
```

- Active: background #222, text trắng, circular, size 40px
- Others: transparent, hover background #F3F1EC

### Editorial Section

```
┌─────────────────────┬─────────────────────────────┐
│                     │                             │
│                     │   FLOWER JOURNAL            │
│    ẢNH HOA          │   Không chỉ là một bó hoa,  │
│    (lifestyle)      │   mà là một câu chuyện.     │
│                     │                             │
│                     │   Khám phá câu chuyện →     │
│                     │                             │
└─────────────────────┴─────────────────────────────┘
```

- Background #F5F2EA
- 50/50 layout, padding 80–100px
- Image border-radius 20px

---

## Responsive Breakpoints

```
Desktop:  ≥1024px  — full layout
Tablet:   768–1023px — reduced columns, smaller spacing
Mobile:   <768px   — 2 columns, hamburger, accordion
```

---

## Overall Guidelines

- **Không**: gradient, glassmorphism, shadow nặng, border đậm, animation mạnh
- **Có**: whitespace rộng, image-first, typography lớn, transition mềm
- **Mỗi section**: scroll animation fade-up nhẹ (500ms)
- **Toàn bộ homepage**: cảm giác luxury florist boutique, không phải marketplace
- **Visual hierarchy**: ảnh hoa > typography > spacing
