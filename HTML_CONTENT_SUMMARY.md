# FlowerShop - HTML Content Summary for UI Design Prompting

> **Mục đích:** Tài liệu này tổng hợp toàn bộ nội dung HTML hiện có trong project để làm cơ sở cho việc prompt thiết kế giao diện mới.

---

## 🎯 TỔNG QUAN PROJECT

**Loại:** E-commerce Flower Shop (Shop hoa tươi cao cấp)  
**Tech Stack:** Laravel Blade Templates + Plain CSS  
**Ngôn ngữ:** Tiếng Việt  
**Target:** Premium, botanical, elegant aesthetic

---

## 📐 CẤU TRÚC LAYOUT CHÍNH

### 1. **Main Layout** (`layouts/app.blade.php`)
```
Structure:
├── <head>
│   ├── Meta tags (charset, viewport, csrf-token)
│   ├── CSS: asset('css/app.css')
│   └── Fonts: Inter (body) + Playfair Display (headings)
├── <body>
│   ├── @include('partials.navbar')
│   ├── <main class="main-content">
│   │   └── @yield('content')
│   ├── @include('partials.footer')
│   └── Global scripts (cart, notifications)
```

**Key Features:**
- Cart count badge system
- AJAX add to cart
- Toast notification helper
- Mobile-first responsive

---

## 🧩 COMPONENTS

### 2. **Navbar** (`partials/navbar.blade.php`)

**Desktop Navigation:**
- Logo (SVG icon + site name)
- Main menu:
  - Trang chủ
  - **Sản phẩm** (Mega Menu - categories từ DB)
  - Góc cảm hứng (Blog)
  - Thông tin (Dropdown - pages từ DB)
  - Liên hệ
- Actions: Search, Cart (with badge), User menu/Login

**Mega Menu Structure:**
- 3 cột danh mục categories
- 1 cột "Xem theo" (sort filters: newest, bestseller, all)
- 1 featured image với CTA

**Mobile Menu:**
- Hamburger toggle
- Full-screen overlay
- Accordion for dropdowns
- User menu integrated

**Interactive:**
- Sticky on scroll (class: `.scrolled`)
- Dropdown hover (desktop) / click (mobile)
- Close on ESC key

---

### 3. **Footer** (`partials/footer.blade.php`)

**4-Column Grid:**
1. **Liên hệ:** Hotline, Email, Địa chỉ, Social icons (Instagram, Facebook, TikTok, Zalo, YouTube)
2. **Danh mục:** Categories links từ DB
3. **Thông tin:** Pages links từ DB + Contact
4. **Newsletter:** Email signup form + consent text

**Bottom Bar:**
- Copyright notice
- Quick links (3 pages)

---

### 4. **Product Card** (`components/product-card.blade.php`)

**Structure:**
```html
<article class="product-card">
  <a href="product-detail">
    <div class="product-card__image-wrap">
      <img primary>
      <img secondary (hover)>
      <span badge (featured)>
      <button wishlist (heart icon)>
      <div overlay with CTA>
    </div>
    <div class="product-card__info">
      <span category>
      <h3 name>
      <div price>
    </div>
  </a>
</article>
```

**Features:**
- Image hover swap
- Wishlist toggle (authenticated)
- Featured badge
- Overlay with "Xem chi tiết" CTA

---

## 📄 PAGES

### 5. **Home Page** (`home/index.blade.php`)

**Sections (in order):**
1. **Hero** - Slider với 3 slides, text overlay, auto-rotate, indicators
2. **Products** - Best selling products grid
3. **Categories** - Category discovery grid
4. **Brand Values** - 3-column value props (quality, delivery, service)
5. **Inspiration** - Blog preview section
6. **Instagram** - Social gallery grid

---

### 6. **Hero Section** (`home/sections/hero.blade.php`)

**Key Elements:**
- Fixed background image (all slides)
- 3 text slides with auto-rotate:
  - Slide 1: "Tạo Khoảnh Khắc Đặc Biệt"
  - Slide 2: "Hoa Tươi Cho Mọi Dịp"
  - Slide 3: "Giao Tận Tay Người Nhận"
- Each slide: label + title + description + CTA button
- Progress indicators (3 dots)
- Counter (01/03)

---

### 7. **Products Page** (`products/index.blade.php`)

**Components:**
1. **Hero Banner** - Image với breadcrumb overlay
2. **Active Filter Chips** - Removable tags showing current filters
3. **Toolbar** - Filter button (badge count) + result count + sort dropdown
4. **Filter Sidebar** - Collapsible (mobile overlay):
   - Search input
   - Categories (checkboxes từ DB)
   - Price range (preset + custom min/max)
   - In stock toggle
   - Apply + Reset buttons
5. **Products Grid** - Product cards grid (responsive columns)
6. **Empty State** - Icon + message + suggestions
7. **Pagination** - Prev/Next + numbered pages
8. **Editorial Section** - CTA block "Câu chuyện về hoa"

**Interactions:**
- Filter sidebar toggle (overlay on mobile)
- Sort dropdown toggle
- Price range validation
- Auto-submit filters (optional)
- Wishlist toggle on cards

---

### 8. **Product Detail** (`products/detail.blade.php`)

**Layout:**
```
Grid (2 columns):
├── LEFT: Product Gallery (2 images, discount badge)
└── RIGHT: Product Info
    ├── Badge (discount/featured)
    ├── Title
    ├── Rating stars (0.0 placeholder)
    ├── Price (sale + original + savings)
    ├── Options (volume/size)
    ├── Stock count
    ├── Quantity selector + Add to cart
    ├── Buy now button
    ├── 3 Benefits icons (cruelty-free, paraben-free, alcohol-free)
    └── Accordion (4 items):
        - Ưu điểm nổi bật
        - Thành phần
        - Hướng dẫn sử dụng
        - Chính sách đổi trả
```

**Below Grid:**
- **Recommended products** section (products grid)
- **Recently viewed** section (smaller cards)
- **Back to top** floating button

**Scripts:**
- Quantity +/- controls
- Quick order (auth check)
- Accordion toggle
- Scroll reveal back-to-top

---

### 9. **Cart Page** (`cart/index.blade.php`)

**Layout:**
```
2-Column:
├── LEFT: Cart Items Card
│   ├── Header (count)
│   ├── Items list:
│   │   - Image
│   │   - Info (name, category, stock warning)
│   │   - Price
│   │   - Quantity selector (form submit on change)
│   │   - Total
│   │   - Remove button
│   └── Actions: Continue shopping + Clear cart
└── RIGHT: Order Summary Card
    ├── Subtotal
    ├── Shipping (TBD)
    ├── Total
    ├── Checkout button
    └── Note
```

**Empty State:**
- Icon (cart)
- "Giỏ hàng trống"
- CTA to products

---

### 10. **Checkout Page** (`checkout/index.blade.php`)

**Layout:**
```
2-Column:
├── LEFT: Checkout Form
│   ├── Contact Info Card:
│   │   - Name, Phone, Email, Zalo ID
│   │   - Message textarea
│   └── Actions: Back to cart + Submit order
└── RIGHT: Order Summary Card
    ├── Items list with thumbnails (qty badge)
    ├── Subtotal
    ├── Shipping (TBD)
    ├── Total
    └── Info boxes:
        - "Không cần thanh toán ngay"
        - Zalo QR code (if set)
```

---

## 🎨 UI PATTERNS & CONVENTIONS

### Typography Hierarchy:
- **Headings:** Playfair Display (serif, elegant)
- **Body:** Inter (sans-serif, modern)
- **Labels:** Uppercase, letter-spacing

### Common Components:
- **Buttons:** Primary, Secondary, Outline variants
- **Forms:** Labeled inputs, error states, required markers
- **Cards:** Header + Body + Footer structure
- **Badges:** Featured, Discount, Stock warnings
- **Icons:** SVG inline, 20x20 standard size
- **Modals/Overlays:** Backdrop + close button + ESC key

### Interactive States:
- Hover: Opacity, transform, color changes
- Active: Class toggle, aria-expanded
- Disabled: Reduced opacity, no pointer events
- Loading: Consider for cart actions

### Responsive Breakpoints (assumed):
- Mobile: < 768px
- Tablet: 768px - 1024px
- Desktop: > 1024px

---

## 📦 CONTENT TYPES

### Dynamic Content từ DB:
1. **Categories** (`$navCategories`) - Tên, slug, mô tả
2. **Pages** (`$navPages`) - Title, slug (policies, about)
3. **Products** - Name, price, sale_price, images, stock, category
4. **Settings** (`$siteSettings`) - Site name, contact, social URLs
5. **Banners** (`$siteBanners`) - Hero images per page

### Static Content:
- Hero slides text (3 variants)
- Brand values text
- Benefits icons + text (cruelty-free, etc.)
- Empty state messages
- Form placeholders

---

## 🔄 USER FLOWS

### 1. Browse Products:
Home → Products page → Filter/Sort → Product detail → Add to cart

### 2. Checkout:
Cart → Review items → Checkout form → Submit order → Success page

### 3. Account:
Login → Profile → Order history → Logout
OR
Register → Verify → Login

### 4. Search:
Click search icon → Modal/dropdown → Type query → Results

### 5. Wishlist:
Heart icon on card → Toggle saved → View saved page

---

## 🎯 KEY FEATURES TO DESIGN FOR

### Must Have:
1. ✅ Product filtering & sorting
2. ✅ Shopping cart with quantity controls
3. ✅ Wishlist (authenticated users)
4. ✅ Responsive mega menu
5. ✅ Image galleries (product detail)
6. ✅ Accordion components
7. ✅ Toast notifications
8. ✅ Loading states
9. ✅ Empty states
10. ✅ Form validation UI

### Nice to Have:
- Search modal with suggestions
- Quick view product modal
- Image zoom on product detail
- Related products carousel
- Reviews/ratings system (placeholder exists)
- Product comparison
- Social share buttons

---

## 📐 DESIGN SYSTEM NEEDS

### Colors (define):
- Primary (brand color)
- Secondary
- Accent
- Success, Warning, Error
- Neutral grays (7 shades)
- Background variations

### Spacing Scale:
- 4px, 8px, 12px, 16px, 24px, 32px, 48px, 64px, 96px

### Border Radius:
- Small (4px), Medium (8px), Large (16px), Full (9999px)

### Shadows:
- sm, md, lg, xl for elevation

### Typography Scale:
- xs, sm, base, lg, xl, 2xl, 3xl, 4xl, 5xl

---

## 🚀 PROMPT SUGGESTIONS

### For Homepage Design:
```
"Design a premium flower shop homepage with elegant botanical aesthetic. 
Include hero slider with 3 text slides over fixed image, bestselling products 
grid (4 columns), category discovery section, brand value props with icons, 
blog preview, and Instagram gallery. Use sage green, cream, and natural tones. 
Serif headings, sans-serif body. Mobile-first responsive."
```

### For Product Page:
```
"E-commerce product listing page with left sidebar filter (categories, price 
range, stock), top toolbar (filter toggle, result count, sort dropdown), 
product grid with hover effects, pagination, and empty state. Editorial 
aesthetic, generous whitespace, botanical theme."
```

### For Product Detail:
```
"Product detail page with 2-column layout: left has image gallery (2 photos, 
discount badge), right has info (title, rating, price with savings, quantity 
selector, CTA buttons, benefit icons, accordion for description/ingredients/
usage/policy). Below: recommended products carousel. Luxury feel, clean design."
```

### For Cart/Checkout:
```
"Shopping cart and checkout pages with 2-column layout: left has item list 
(image, name, price, quantity controls, remove), right has order summary 
sticky sidebar (subtotal, shipping TBD, total, CTA). Checkout adds contact 
form. Premium botanical theme, trust indicators."
```

---

## 📝 NOTES FOR DESIGNER

- **Brand Voice:** Premium but accessible, botanical elegance
- **Target Audience:** Urban 25-45, gift givers, special occasions
- **Competitors:** Flora, Bloom & Wild, luxury florists
- **Key Differentiators:** Fresh imported flowers, fast delivery, no upfront payment
- **Accessibility:** Consider WCAG AA, keyboard navigation, screen readers
- **Performance:** Optimize images, lazy loading, minimize CSS/JS
- **Localization:** Vietnamese language, VND currency, local delivery context

---

## 🔗 FILES REFERENCE

### Layouts:
- `resources/views/layouts/app.blade.php`

### Components:
- `resources/views/partials/navbar.blade.php`
- `resources/views/partials/footer.blade.php`
- `resources/views/components/product-card.blade.php`
- `resources/views/components/page-hero.blade.php`

### Pages:
- `resources/views/home/index.blade.php`
- `resources/views/products/index.blade.php`
- `resources/views/products/detail.blade.php`
- `resources/views/cart/index.blade.php`
- `resources/views/checkout/index.blade.php`

### Sections:
- `resources/views/home/sections/hero.blade.php`
- `resources/views/home/sections/products.blade.php`
- `resources/views/home/sections/categories.blade.php`
- `resources/views/home/sections/brand-values.blade.php`
- `resources/views/home/sections/inspiration.blade.php`
- `resources/views/home/sections/instagram.blade.php`

---

## 🔐 ADMIN PANEL

### 11. **Admin Layout** (`layouts/admin.blade.php`)

**Structure:**
```
├── <head>
│   ├── Meta tags
│   ├── CSS: asset('css/app.css')
│   └── Fonts: Nunito
├── <body>
│   └── <div class="admin-layout">
│       ├── @include('admin.partials.sidebar')
│       └── <div class="admin-main">
│           ├── @include('admin.partials.topbar')
│           └── <div class="admin-content">
│               ├── Alerts (success/error)
│               └── @yield('content')
```

**Global Scripts:**
- Mobile sidebar toggle
- Confirm delete actions
- Image preview helper
- Auto-dismiss alerts (5s)
- Form validation helper

---

### 12. **Admin Sidebar** (`admin/partials/sidebar.blade.php`)

**Structure:**
- **Logo Header:** Icon + "Lâm Nhiên Thảo" + "Admin Panel"
- **Navigation Sections:**
  1. **Chính:** Dashboard
  2. **Quản Lý:** Categories, Products, Inquiries (with badge), Posts
  3. **Hệ Thống:** Users, Pages, Settings
- **Footer:** "Xem Trang Web" link

**Features:**
- Active state highlighting
- Badge notifications (new inquiries)
- Icon per menu item (SVG inline)
- Mobile responsive (toggle overlay)

---

### 13. **Admin Topbar** (`admin/partials/topbar.blade.php`)

**Left Side:**
- Mobile menu toggle button
- Breadcrumb: Admin / [Current Page]

**Right Side:**
- Notifications button (with badge)
- Quick Add Product button
- User avatar (first letter) + name + role
- Logout button

---

### 14. **Dashboard** (`admin/dashboard.blade.php`)

**Page Header:**
- Title: "Bảng Điều Khiển"
- Subtitle: Welcome message
- Action: "Thêm Sản Phẩm" button

**Stats Grid (4 cards):**
1. **Tổng Sản Phẩm** - Primary icon (box)
2. **Danh Mục** - Success icon (tag)
3. **Liên Hệ** - Warning icon (document) + "X liên hệ mới" badge
4. **Người Dùng** - Info icon (users)

**Main Content Grid (2 columns):**

**Left: Recent Inquiries Card**
- Header with "Xem Tất Cả" button
- Table: ID, Customer, Phone, Products, Status (badges: pending/contacted/completed), Date
- Empty state if no inquiries

**Right: Low Stock Alert Card**
- Header with "Tất Cả Sản Phẩm" button
- Stock items list: Image + Name + Category | Badge (out of stock / low stock)
- Empty state: "Tất cả sản phẩm đều đủ hàng"

---

### 15. **Products Index** (`admin/products/index.blade.php`)

**Page Header:**
- Title + subtitle
- "Thêm Sản Phẩm" button

**Filters Card:**
- Search input (product name)
- Category dropdown
- Status dropdown (active/inactive)
- Filter + Clear buttons

**Products Table:**
- Columns: Image (80px), Name, Category, Price, Stock, Status, Actions
- Image thumbnail (56x56)
- Name with "Nổi bật" badge if featured
- Stock badges: danger (out), warning (< 10), success (≥ 10)
- Status badges: success/secondary
- Actions: Edit icon + Delete icon (confirm dialog)
- Empty state
- Pagination

---

### 16. **Product Form** (`admin/products/form.blade.php`)

**Create/Edit Page:**

**3 Cards Layout:**

**1. Product Information Card:**
- Product Name (required)
- Category dropdown (required)
- Price + Stock (2-column grid, required)
- Short Description (textarea)

**2. Product Images Card:**
- File upload (multiple, accept images)
- Image preview grid (shows uploaded)
- Existing images (if edit):
  - Grid with "Ảnh chính" badge on primary
  - Checkbox to delete each image

**3. Status Card:**
- Checkbox: "Kích hoạt" (is_active)
- Checkbox: "Sản phẩm nổi bật" (is_featured)

**Form Actions:**
- Full-width submit button: "Tạo Sản Phẩm" / "Cập Nhật Sản Phẩm"

**Scripts:**
- Image preview on file select
- Primary badge on first image

---

### 17. **Categories Index** (`admin/categories/index.blade.php`)

**Similar structure to Products Index:**

**Filters Card:**
- Search input
- Status dropdown
- Filter + Clear buttons

**Categories Table:**
- Columns: Image, Name, Slug (monospace), Parent Category, Products Count, Status, Actions
- Image or placeholder icon
- Products count badge
- Status badges
- Edit + Delete actions
- Empty state
- Pagination

---

### 18. **Settings Page** (`admin/settings/index.blade.php`)

**Success Alert** (if session)

**2-Column Grid of Cards:**

**Row 1:**
1. **General Settings:**
   - Site Name (required)
   - Slogan
   - Site Description (textarea)
   - Site Logo (file upload + preview if exists)

2. **Contact Information:**
   - Email
   - Phone
   - Address (textarea)
   - Zalo ID
   - About (textarea)

**Row 2:**
3. **Social Media:**
   - Facebook URL
   - Instagram URL
   - TikTok URL
   - YouTube URL

4. **Business Hours:**
   - Business Hours (textarea, monospace font)
   - Default: Mon-Fri, Sat, Sun schedules

**Row 3:**
5. **SEO Settings:**
   - Meta Title
   - Meta Description
   - Meta Keywords

6. **Email Settings:**
   - Order Notification Email
   - Contact Form Email

**Full-Width Card:**
7. **Banner Images:**
   - Description: "1600x600px recommended"
   - Grid of 8 banner uploads:
     - Home, Products, Categories, Blog, About, Contact, Cart, Checkout
   - Each: Label + file input + preview (if exists)

**Form Actions:**
- Right-aligned "Lưu Cài Đặt" button

---

## 🎨 ADMIN UI PATTERNS

### Admin-Specific Components:

**1. Stats Card:**
- Icon (colored: primary/success/warning/info)
- Label + Value
- Optional badge

**2. Admin Card:**
- Header: Title (with icon) + Action button
- Body: Content
- Footer: Pagination or actions

**3. Admin Table:**
- Wrapper with horizontal scroll
- Styled thead/tbody
- Hover states on rows
- Icons for actions
- Empty state component

**4. Table Actions:**
- Icon buttons: Edit (pencil) + Delete (trash)
- Inline form for delete (POST with @method('DELETE'))
- Confirm dialog on delete

**5. Badges:**
- Colors: primary, success, warning, danger, info, secondary, accent
- Small size, rounded, inline

**6. Form Elements:**
- `.form-group` wrapper
- `.form-label` (with `.required` for asterisk)
- `.form-input` with error states
- `.form-error` for validation
- `.form-checkbox` styled
- `.form-help` for hints

**7. Filters:**
- Horizontal form with inputs + buttons
- Small size variants (`.input-sm`, `.btn-sm`)
- Inline layout

**8. Empty State:**
- `.empty-state-sm` for table cells
- Icon (SVG, large) + message
- Center-aligned

**9. Image Preview:**
- `.table-image` (56x56, rounded)
- `.image-preview-grid` for uploads
- `.image-badge` for labels (primary, etc.)

### Admin Color Scheme (assumed):
- Background: Light gray (#f5f5f5 or similar)
- Sidebar: Dark or navy
- Cards: White with shadow
- Text: Dark gray hierarchy
- Accent: Brand color
- States: Success (green), Warning (yellow), Danger (red), Info (blue)

### Admin Typography:
- Font: Nunito (rounded, friendly)
- Monospace: For slugs, IDs, code

### Admin Layout:
- Sidebar: Fixed left (~240px width)
- Main: Right side, full height
- Topbar: Fixed top, horizontal
- Content: Padded container

### Responsive Behavior:
- Mobile (< 1024px): Sidebar becomes overlay/drawer
- Toggle button in topbar
- Full-width cards on mobile
- Horizontal scroll for tables

---

## 🎯 ADMIN PROMPT SUGGESTIONS

### For Admin Dashboard:
```
"Admin dashboard with 4 stat cards (products, categories, inquiries, users), 
recent inquiries table, low stock alert list. Clean modern design, card-based 
layout, icon emphasis, status badges. Navy sidebar, white content area."
```

### For Admin Data Tables:
```
"Data table with filters (search, dropdown, buttons), sortable columns, 
thumbnail images, status badges, inline action buttons (edit, delete). 
Pagination at bottom. Empty state with icon. Professional admin aesthetic."
```

### For Admin Forms:
```
"Multi-section form with cards: product info, image uploads with preview, 
status toggles. Clean labels, validation states, help text. Full-width 
submit button. Modern admin panel style."
```

### For Admin Settings:
```
"Settings page with 2-column grid of cards: general, contact, social, 
business hours, SEO, email. File uploads with previews. Banner management 
grid. Organized, scannable layout."
```

---

**Generated:** 2026-09-16  
**Project:** FlowerShop Premium E-commerce  
**Purpose:** UI Design Prompting Reference
