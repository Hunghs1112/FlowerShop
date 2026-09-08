# 🌸 Hero Section Design - Premium Florist Website

## 🎯 Tổng Quan

Hero section full-screen cao cấp với **text slider** và **background image cố định**, được thiết kế đặc biệt cho website bán hoa tươi luxury.

---

## ✨ Đặc Điểm Chính

### 1. **Full-Screen Layout**
- Chiều cao: **100vh** (full viewport)
- Chiều rộng: **100%**
- Background image phủ toàn bộ hero từ edge-to-edge
- Nằm ngay dưới navbar, không có khoảng trắng

### 2. **Background Image Cố Định**
- **Một ảnh duy nhất** cho toàn bộ slider
- Background KHÔNG thay đổi khi chuyển slide
- Ảnh hoa tươi cao cấp, tone màu tự nhiên
- Gradient overlay nhẹ để text dễ đọc

### 3. **Text Slider**
- **3 slides** với nội dung khác nhau
- Chỉ text thay đổi, background giữ nguyên
- Autoplay: 6 giây/slide
- Pause khi hover
- Manual navigation

---

## 📐 Bố Cục

```
┌─────────────────────────────────────────────────────────┐
│                                                         │
│   ┌─────────────────┐                                  │
│   │ LABEL           │                                  │
│   │                 │                                  │
│   │ Heading Line 1  │         [Background Image]      │
│   │ Heading Line 2  │                                  │
│   │                 │                                  │
│   │ Description     │                                  │
│   │ text here...    │                                  │
│   │                 │                                  │
│   │ [ CTA Button → ]│                                  │
│   └─────────────────┘                                  │
│                                                         │
│   ━━━ ━━━ ━━━  01 / 03                                │
└─────────────────────────────────────────────────────────┘
```

### Text Area (Left)
- Chiều rộng: **45%** màn hình
- Max-width: **580px**
- Padding: **60px** từ mép trái

### Nội Dung Mỗi Slide

1. **Eyebrow Label**
   - Font: 13px, weight 600
   - Uppercase, letter-spacing 1.5px
   - Background: rgba blur
   - Border-radius: 50px

2. **Heading**
   - Font: 42-64px responsive
   - Weight: 700
   - Line-height: 1.1
   - Max 2 dòng
   - Color: #FFFFFF
   - Text shadow nhẹ

3. **Description**
   - Font: 17px
   - Line-height: 1.65
   - Max-width: 520px
   - Color: rgba(255,255,255,0.95)

4. **CTA Button**
   - Rounded: 50px
   - Padding: 15px 32px
   - Background: Dusty Rose
   - Icon arrow bên phải
   - Hover: lift + shadow

---

## 🎬 Slide Content

### Slide 1: Hoa Tươi Mỗi Ngày
```
Label: "HOA TƯƠI MỖI NGÀY"

Heading:
"Trao hoa,
trao những điều đẹp nhất"

Description:
"Những bó hoa tươi được tuyển chọn kỹ lưỡng,
gói ghém trọn vẹn tình cảm dành cho người bạn yêu thương."

CTA: "Khám phá hoa tươi →"
```

### Slide 2: Hoa Nhập Khẩu
```
Label: "HOA NHẬP KHẨU"

Heading:
"Vẻ đẹp tinh tế
từ những mùa hoa trên thế giới"

Description:
"Khám phá những giống hoa nhập khẩu được tuyển chọn
và chăm sóc cẩn thận để giữ trọn vẻ đẹp tự nhiên."

CTA: "Khám phá hoa nhập khẩu →"
```

### Slide 3: Dịp Đặc Biệt
```
Label: "DỊP ĐẶC BIỆT"

Heading:
"Một bó hoa,
ngàn lời muốn nói"

Description:
"Những thiết kế hoa dành riêng cho sinh nhật,
kỷ niệm, tình yêu và những khoảnh khắc đáng nhớ."

CTA: "Chọn hoa cho dịp đặc biệt →"
```

---

## 🎨 Styling Details

### Colors
```css
Text: #FFFFFF
Label BG: rgba(255, 255, 255, 0.15) + backdrop-filter
CTA: var(--color-accent-primary) (#D4A5A5)
Gradient Overlay: 
  - Left: rgba(0,0,0,0.35)
  - Center: rgba(0,0,0,0.15)
  - Right: transparent
```

### Typography
```css
Label: 13px / 600 / uppercase / 1.5px letter-spacing
Heading: clamp(42px, 5vw, 64px) / 700 / 1.1 line-height
Description: 17px / 400 / 1.65 line-height
CTA: 15px / 600
```

### Spacing
```css
Label margin-bottom: 32px
Heading margin-bottom: 24px
Description margin-bottom: 36px
Container padding: 0 60px
```

---

## 🎯 Slider Controls

### Progress Indicators
```
━━━━  ━━━━  ━━━━
```
- 3 bars, mỗi bar 40px x 3px
- Background: rgba(255,255,255,0.3)
- Active: white progress bar animation 6s
- Clickable để chuyển slide

### Counter
```
01 / 03
```
- Font: 14px mono
- Current number: 16px bold
- Tabular numerals

### Position
- Bottom-left: 48px from bottom, 60px from left
- Responsive: adjusted for mobile

---

## 🎭 Animations

### Slide Transition (600ms)
```javascript
Text Out:
- opacity: 1 → 0
- No transform (smooth fade)

Text In:
- opacity: 0 → 1
- Elements cascade with delays:
  • Label: 0.1s delay
  • Heading: 0.2s delay  
  • Description: 0.3s delay
  • CTA: 0.4s delay
```

### Hover Effects
```css
CTA Button:
- translateY(-2px)
- box-shadow increase
- Icon translateX(4px)
```

### Progress Bar
```css
@keyframes indicatorProgress {
  from { width: 0% }
  to { width: 100% }
}
Duration: 6s linear
```

---

## 🎮 JavaScript Features

### Autoplay
- **6 seconds** per slide
- Auto-start on page load
- Loops infinitely

### Pause/Resume
- **Pause** on hover
- **Pause** when tab hidden
- **Resume** on mouse leave

### Navigation
- Click indicators to jump to slide
- Keyboard: Arrow Left/Right
- Reset autoplay on manual navigation

### Accessibility
- ARIA labels on indicators
- Keyboard navigation support
- Respects `prefers-reduced-motion`
- Pause animations if reduced motion preferred

---

## 📱 Responsive Design

### Desktop (>1024px)
```css
Height: 100vh
Text width: 45%
Heading: 52-64px
Padding: 0 60px
Controls: bottom-left
```

### Tablet (768-1024px)
```css
Height: 100vh
Text width: 55%
Heading: 42-52px
Padding: 0 40px
```

### Mobile (<768px)
```css
Height: 85vh (min 650px)
Text width: 100%
Heading: 32-42px
Padding: 0 24px
Alignment: bottom (with padding-bottom 100px)
Gradient: darker for readability
CTA: full width
Controls: stack vertically
Indicators: full width bars
```

---

## 🖼️ Background Image

### Recommended Specs
- **Resolution**: 2400px+ width
- **Format**: JPEG (optimized) or WebP
- **Aspect ratio**: 16:9 or wider
- **Subject**: Fresh flowers, bouquet, florist space
- **Lighting**: Natural, soft
- **Colors**: Pastel, dusty rose, sage green, cream, beige
- **Quality**: High-res editorial photography

### Current Image
```
https://images.unsplash.com/photo-1518895949257-7621c3c786d7
?q=80&w=2400&auto=format&fit=crop
```

### CSS Properties
```css
object-fit: cover;
object-position: center center;
```

---

## 🔧 Technical Implementation

### Files Modified
| File | Purpose |
|------|---------|
| `resources/css/hero.css` | Complete hero styling |
| `resources/views/home.blade.php` | HTML structure + JavaScript |
| `public/css/hero.css` | Production CSS |

### HTML Structure
```html
<section class="hero" id="heroSection">
  <div class="hero-background">
    <img class="hero-background-image" />
  </div>
  
  <div class="hero-container">
    <div class="hero-content">
      <div class="hero-slide active">
        <span class="hero-label">...</span>
        <h1 class="hero-title">...</h1>
        <p class="hero-description">...</p>
        <a class="hero-cta">...</a>
      </div>
      <!-- More slides -->
    </div>
  </div>
  
  <div class="hero-controls">
    <div class="hero-indicators">...</div>
    <div class="hero-counter">...</div>
  </div>
</section>
```

---

## ⚡ Performance

### Optimizations
- Single background image (no carousel)
- CSS animations (GPU accelerated)
- Lightweight JavaScript (~140 lines)
- `loading="eager"` on hero image
- No external slider libraries

### Load Time
- Hero visible immediately
- Background loads with priority
- Text content renders instantly
- Progressive enhancement

---

## ♿ Accessibility

✅ **Keyboard Navigation**
- Arrow keys to navigate
- Tab to focus indicators

✅ **Screen Readers**
- ARIA labels on controls
- Semantic HTML structure
- Alt text on background image

✅ **Motion Sensitivity**
- Respects `prefers-reduced-motion`
- Disables autoplay if preferred
- Shorter transitions

✅ **Focus Management**
- Visible focus states
- Logical tab order

---

## 🎨 Design Philosophy

### Luxury Florist Aesthetic
- **Minimal** - không quá nhiều elements
- **Elegant** - typography tinh tế
- **Emotional** - imagery tạo cảm xúc
- **Premium** - materials và colors cao cấp
- **Natural** - tone màu tự nhiên

### Visual Hierarchy
1. **Background Image** - visual anchor
2. **Heading** - primary message
3. **Description** - supporting text
4. **CTA** - action trigger
5. **Controls** - secondary navigation

---

## 🚀 Usage

### View Hero
```
http://localhost:8000
```

### Customization

**Change Background Image:**
```html
<img src="YOUR_IMAGE_URL" 
     alt="..." 
     class="hero-background-image">
```

**Add New Slide:**
```html
<div class="hero-slide" data-slide="3">
  <span class="hero-label">YOUR LABEL</span>
  <h1 class="hero-title">Your Heading</h1>
  <p class="hero-description">Your description...</p>
  <a href="#" class="hero-cta">Your CTA →</a>
</div>
```

**Adjust Timing:**
```javascript
const slideDuration = 6000; // Change to desired ms
```

---

## ✅ Testing Checklist

### Desktop
- [ ] Hero fills 100vh
- [ ] Text readable over background
- [ ] Slides auto-advance every 6s
- [ ] Hover pauses autoplay
- [ ] Click indicators changes slides
- [ ] Keyboard arrows work
- [ ] Progress bars animate
- [ ] CTA buttons work

### Tablet
- [ ] Layout adapts smoothly
- [ ] Text remains readable
- [ ] Touch interactions work

### Mobile
- [ ] Hero height appropriate
- [ ] Text at bottom with padding
- [ ] CTA full-width and tappable
- [ ] Indicators stack properly
- [ ] Swipe (if implemented)

### Accessibility
- [ ] Keyboard navigation works
- [ ] Screen reader announces slides
- [ ] Reduced motion respected
- [ ] Focus visible

---

## 🎉 Kết Quả

Hero section mới đã sẵn sàng với:

✨ **Full-screen luxury design**  
🎬 **Smooth text slider với 3 slides**  
🖼️ **Background image cố định cao cấp**  
📱 **Responsive hoàn chỉnh**  
♿ **Accessibility compliant**  
⚡ **Performance optimized**  
🎯 **User experience xuất sắc**

**Perfect cho premium florist website! 🌸**
