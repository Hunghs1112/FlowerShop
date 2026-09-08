# UI Optimization Log - FlowerShop

## Ngày 8 Tháng 9, 2026

### 🎨 Tối ưu Product Card Layout

#### Vấn đề:
- Product cards có aspect ratio ngang (1/1.08) không phù hợp với website bán hoa cao cấp
- Layout ngang làm card trông giống marketplace thông thường
- Không tạo cảm giác premium florist editorial

#### Giải pháp:
Thay đổi aspect ratio từ **1/1.08** → **3/4** (portrait/dọc)

#### Files đã update:

1. **Homepage Products Section**
   - `/public/css/products-section.css`
   - `/resources/css/products-section.css`
   - Aspect ratio: `3 / 4`
   - Gap: 20px → 24px desktop
   
2. **Products Page**
   - `/public/css/products/card.css`
   - `/resources/css/products/card.css`
   - Aspect ratio: `3 / 4`
   - Giữ nguyên gap 22px

#### Lợi ích:

✅ **Vertical composition phù hợp với hoa**
- Hoa thường được chụp theo chiều dọc (portrait)
- Bó hoa, hộp hoa, giỏ hoa đều có chiều cao > chiều rộng
- Tạo cảm giác sang trọng, editorial

✅ **Premium aesthetic**
- Layout dọc giống lookbook của florist cao cấp
- Không giống marketplace (thường dùng square 1/1)
- Tập trung vào hình ảnh hoa

✅ **Responsive tốt hơn**
- Mobile: 2 columns vẫn đẹp với aspect 3/4
- Tablet: 3 columns không bị chật
- Desktop: 4 columns có breathing room

#### Breakpoints:

```css
Desktop (≥1024px):
- Grid: 4 columns
- Gap: 24px
- Aspect: 3/4
- Border-radius: 22px

Tablet (768-1023px):
- Grid: 3 columns
- Gap: 20px
- Aspect: 3/4
- Border-radius: 20px

Mobile (<768px):
- Grid: 2 columns
- Gap: 14px
- Aspect: 3/4
- Border-radius: 16px
```

#### Visual Comparison:

**Trước:**
```
┌─────┐ ┌─────┐ ┌─────┐ ┌─────┐
│  1  │ │  2  │ │  3  │ │  4  │  ← Ngang, giống marketplace
│ :1  │ │ :1  │ │ :1  │ │ :1  │
└─────┘ └─────┘ └─────┘ └─────┘
```

**Sau:**
```
┌───┐   ┌───┐   ┌───┐   ┌───┐
│ 1 │   │ 2 │   │ 3 │   │ 4 │    ← Dọc, premium florist
│ 3 │   │ 3 │   │ 3 │   │ 3 │
│ : │   │ : │   │ : │   │ : │
│ 4 │   │ 4 │   │ 4 │   │ 4 │
└───┘   └───┘   └───┘   └───┘
```

#### References:

Các florist brands cao cấp dùng portrait:
- [Bloom & Wild](https://www.bloomandwild.com)
- [The Bouqs Co](https://www.thebouqs.com)
- [UrbanStems](https://urbanstems.com)
- [Floom](https://www.floom.com)

---

### 📁 CSS Module Organization

Đã chia CSS products page thành modules:

```
resources/css/products/
├── hero.css          # Hero banner
├── toolbar.css       # Filter + Sort
├── filter.css        # Filter sidebar
├── grid.css          # Grid layout
├── card.css          # Product card
├── pagination.css    # Pagination
├── editorial.css     # Bottom section
├── index.css         # Master import
└── README.md         # Documentation
```

#### Lợi ích:
- ✅ Dễ tìm kiếm và sửa
- ✅ Mỗi file < 250 dòng
- ✅ Component-based
- ✅ Reusable
- ✅ Team collaboration friendly

---

### 🎯 Next Steps:

#### Tối ưu tiếp:
1. [ ] Check và cải thiện category cards layout
2. [ ] Tối ưu blog cards (inspiration section)
3. [ ] Review hero section spacing
4. [ ] Optimize brand values section
5. [ ] Improve Instagram gallery layout
6. [ ] Add lazy loading cho images
7. [ ] Performance audit

#### Typography:
- [ ] Review font sizes across sections
- [ ] Check line-heights
- [ ] Ensure consistent letter-spacing
- [ ] Mobile typography optimization

#### Spacing:
- [ ] Audit section padding
- [ ] Check element margins
- [ ] Ensure consistent gaps
- [ ] Review whitespace balance

#### Colors:
- [ ] Verify accent color usage
- [ ] Check border colors consistency
- [ ] Review hover states
- [ ] Ensure WCAG contrast

---

### 💡 Design Philosophy:

**Premium Florist Editorial**
- Image-first design
- Vertical compositions
- Generous whitespace  
- Minimal UI elements
- Natural color palette
- Elegant typography
- Subtle interactions
- No heavy shadows
- No gradients
- No glassmorphism

**Target aesthetic:**
> Luxury flower boutique × Editorial magazine × Natural beauty

---

## Người thực hiện:
Kiro AI - Tuesday Sep 8, 2026, 8:50 AM (UTC+7)

## Status: ✅ Completed
