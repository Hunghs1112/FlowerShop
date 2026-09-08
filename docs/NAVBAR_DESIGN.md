# Navbar Design - Premium Florist Website

## Tổng Quan

Navbar đã được thiết kế lại hoàn toàn với phong cách **modern, minimal, elegant** phù hợp cho website bán hoa tươi cao cấp. Thiết kế lấy cảm hứng từ các website florist cao cấp với bố cục: **Logo trái → Navigation giữa → Action icons phải**.

---

## 🎨 Bảng Màu Sắc (Theme Colors)

### Màu Cơ Bản
```css
--color-white: #FFFFFF
--color-bg-primary: #FFFFFF
--color-bg-secondary: #FAFAFA
--color-bg-tertiary: #F5F5F5
```

### Màu Chữ
```css
--color-text-primary: #222222    /* Chữ chính */
--color-text-secondary: #777777  /* Chữ phụ */
--color-text-muted: #999999      /* Chữ mờ */
```

### Màu Viền
```css
--color-border: #EEEEEE          /* Viền chính */
--color-border-medium: #DDDDDD   /* Viền đậm hơn */
```

### Màu Accent - Dusty Rose Palette (Phù hợp florist)
```css
--color-accent-primary: #D4A5A5           /* Dusty Rose - màu chủ đạo */
--color-accent-primary-dark: #B88B8B      /* Hover state */
--color-accent-primary-light: #E8D5D5     /* Background nhẹ */

--color-accent-secondary: #A8B5A0         /* Sage Green - bổ sung */
--color-accent-tertiary: #8B5A5A          /* Burgundy - nhấn mạnh */
```

---

## 📐 Cấu Trúc Navbar

### Kích Thước
- **Desktop**: Chiều cao 80px
- **Mobile**: Chiều cao 68px
- **Max-width**: 1360px (container)
- **Background**: Trắng hoàn toàn (#FFFFFF)
- **Border-bottom**: 1px solid #EEEEEE

### Bố Cục 3 Phần

#### 1. Logo (Bên Trái)
```
┌─────────────────┐
│ 🌸 Petals & Bloom │
└─────────────────┘
```
- Icon hoa 32x32px
- Font size: 20px, weight: 600
- Màu icon: var(--color-accent-primary)
- Min-width: 140px

#### 2. Navigation (Giữa)
```
Trang chủ | Hoa tươi ▾ | Hoa nhập khẩu ▾ | Bó hoa | Hộp hoa | Hoa cưới ▾ | Góc làm đẹp | Liên hệ
```

**Menu Items:**
- Trang chủ
- Hoa tươi (có dropdown)
- Hoa nhập khẩu (có dropdown)
- Bó hoa
- Hộp hoa
- Hoa cưới (có dropdown)
- Góc làm đẹp
- Liên hệ

**Styling:**
- Font size: 14.5px
- Font weight: 400 (active: 500)
- Màu: #777777 (hover: #D4A5A5, active: #222222)
- Khoảng cách: 32px giữa các items
- Letter spacing: 0.01em

**Dropdown Menu:**
- Nền trắng, border: 1px solid #EEEEEE
- Border-radius: 8px
- Shadow: 0 4px 16px rgba(0,0,0,0.06)
- Min-width: 200px
- Hiển thị khi hover

#### 3. Action Icons (Bên Phải)
```
🔍  ♡  👤  🛍️
```

**Icons:**
1. **Search** - Tìm kiếm
2. **Heart** - Yêu thích
3. **User** - Tài khoản (có dropdown menu)
4. **Shopping Bag** - Giỏ hàng (có badge số lượng)

**Styling:**
- Kích thước icon: 21x21px
- Stroke width: 1.7
- Kích thước button: 40x40px
- Khoảng cách: 20px
- Hover: background #FAFAFA, color #D4A5A5

**Cart Badge:**
- Kích thước: 17x17px
- Background: var(--color-accent-primary)
- Font size: 10px, weight: 600
- Vị trí: top-right của icon

---

## 💡 Tính Năng Đặc Biệt

### 1. Sticky Navigation
- Navbar luôn cố định ở top khi scroll
- Khi scroll xuống thêm shadow nhẹ: `box-shadow: 0 2px 8px rgba(0,0,0,0.04)`

### 2. Dropdown Menu
- **Desktop**: Hiển thị khi hover
- **Animation**: Fade in mượt mà
- **Items**: Padding rộng rãi, hover có background

### 3. User Menu Dropdown
Khi đăng nhập hiển thị:
- Tài khoản của tôi
- Đơn hàng
- Yêu thích
- ---
- Quản trị (nếu là admin)
- ---
- Đăng xuất

### 4. Mobile Menu
- Hamburger icon ở phía phải
- Fullscreen overlay menu
- Typography lớn, dễ chạm
- Khoảng cách rộng giữa items
- Tự động đóng khi click link

---

## 📱 Responsive Design

### Desktop (≥1024px)
- Hiển thị đầy đủ navigation menu
- Logo + Menu + Actions nằm trên 1 hàng
- Dropdown menu hoạt động

### Tablet (768px - 1023px)
- Ẩn navigation menu
- Hiển thị hamburger menu
- Giảm padding container

### Mobile (<768px)
- Navbar height: 68px
- Logo font-size: 18px
- Icon size: 20px
- Ẩn text trong user toggle
- Mobile menu fullscreen

---

## 🎯 Accessibility

### Keyboard Navigation
- Tất cả elements có thể focus bằng Tab
- Focus state rõ ràng

### ARIA Labels
```html
aria-label="Tìm kiếm"
aria-label="Yêu thích"
aria-label="Giỏ hàng"
aria-label="Menu người dùng"
aria-label="Menu"
```

### Semantic HTML
- `<nav>` element
- `<ul>` và `<li>` cho menu
- `<button>` cho interactive elements

---

## 🚀 JavaScript Features

### 1. Scroll Detection
```javascript
window.addEventListener('scroll', () => {
    if (currentScroll > 10) {
        navbar.classList.add('scrolled');
    }
});
```

### 2. User Menu Toggle
- Click toggle để mở/đóng
- Click outside để đóng
- Event propagation được xử lý

### 3. Mobile Menu
- Toggle active class
- Lock body scroll khi menu mở
- Auto-close khi resize về desktop
- Close khi click link

---

## 📝 Cách Sử Dụng

### Include trong Layout
```php
@include('partials.navbar')
```

### CSS Dependencies
Đảm bảo import theo thứ tự:
```html
<link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
<link rel="stylesheet" href="{{ asset('css/theme.css') }}">
<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
```

### Highlight Active Menu
```php
class="{{ request()->routeIs('home') ? 'active' : '' }}"
```

---

## 🎨 Typography

### Fonts
- **Sans-serif**: Inter (400, 500, 600, 700)
- **Monospace**: IBM Plex Mono (cho code/numbers)

### Font Loading
```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
```

---

## ✨ Transitions & Animations

### Timing
```css
--transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1)
--transition-base: 200ms cubic-bezier(0.4, 0, 0.2, 1)
--transition-slow: 300ms cubic-bezier(0.4, 0, 0.2, 1)
```

### Hover States
- Màu sắc: 200ms
- Background: 200ms
- Transform: 300ms

---

## 🔧 Customization

### Thay Đổi Màu Accent
Edit trong `resources/css/theme.css`:
```css
--color-accent-primary: #YOUR_COLOR;
--color-accent-primary-dark: #YOUR_DARKER_COLOR;
```

### Thay Đổi Logo
Edit trong `resources/views/partials/navbar.blade.php`:
```html
<span class="navbar-logo-text">Your Brand Name</span>
```

### Thêm Menu Item
```html
<li class="navbar-nav-item">
    <a href="{{ route('your.route') }}" class="navbar-nav-link">
        Menu Name
    </a>
</li>
```

---

## 📦 Files Changed

1. **resources/css/theme.css** - Theme colors updated
2. **resources/css/navbar.css** - Complete navbar redesign
3. **resources/views/partials/navbar.blade.php** - HTML structure
4. **public/css/theme.css** - Production CSS
5. **public/css/navbar.css** - Production CSS

---

## ✅ Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

---

## 🎉 Kết Luận

Navbar mới đã được thiết kế với:
- ✅ Phong cách premium florist
- ✅ Màu sắc nhẹ nhàng, thanh lịch (Dusty Rose)
- ✅ Bố cục cân đối, whitespace rộng rãi
- ✅ Responsive hoàn chỉnh
- ✅ Accessibility tốt
- ✅ Animations mượt mà
- ✅ User experience tối ưu

**Brand Identity**: Petals & Bloom - Hoa tươi cao cấp với cảm giác sang trọng nhưng gần gũi.
