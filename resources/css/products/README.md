# Products Page CSS Structure

Cấu trúc CSS cho trang sản phẩm được chia thành các module riêng biệt để dễ quản lý.

## Files

### 1. `hero.css`
- Hero banner full-width
- Breadcrumb
- Heading và description
- Overlay và image styling
- **Lines**: ~120

### 2. `toolbar.css`
- Filter button
- Product count display
- Sort dropdown
- Toolbar layout
- **Lines**: ~150

### 3. `filter.css`
- Filter sidebar/drawer
- Filter groups
- Checkboxes
- Filter overlay
- Apply/Clear buttons
- **Lines**: ~280

### 4. `card.css`
- Product card styling
- Image với hover effects
- Badge và wishlist
- Category tag
- Price display
- Overlay button
- **Lines**: ~320

### 5. `grid.css`
- Products grid layout
- Container và spacing
- Responsive columns
- Grid gaps
- **Lines**: ~80

### 6. `pagination.css`
- Pagination controls
- Active states
- Navigation buttons
- **Lines**: ~100

### 7. `editorial.css`
- Bottom editorial section
- Image + content layout
- CTA button
- **Lines**: ~140

### 8. `index.css`
- Import tất cả các files trên
- Dùng để load một lần

## Usage

### Option 1: Load individual files (Recommended)
```blade
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/toolbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/grid.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/pagination.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/editorial.css') }}">
@endpush
```

### Option 2: Load all via index
```blade
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/products/index.css') }}">
@endpush
```

## Benefits

✅ **Dễ tìm** - Mỗi component có file riêng
✅ **Dễ sửa** - Không phải scroll qua hàng nghìn dòng
✅ **Dễ debug** - Biết chính xác file nào cần sửa
✅ **Reusable** - Có thể dùng lại card.css ở pages khác
✅ **Maintainable** - Team dễ collaborate
✅ **Performance** - Có thể lazy load hoặc optimize từng file

## File Size

- hero.css: ~3.2KB
- toolbar.css: ~3.8KB
- filter.css: ~7.5KB
- card.css: ~8.2KB
- grid.css: ~2.1KB
- pagination.css: ~2.5KB
- editorial.css: ~3.5KB

**Total**: ~31KB (uncompressed)

## Responsive Breakpoints

Tất cả files tuân theo breakpoints:
- Desktop: ≥ 1024px
- Tablet: 768px - 1023px
- Mobile: < 768px
