# Home Page - Developer Guide

## 📁 Structure

```
home/
├── index.blade.php              ← Main entry point (29 lines)
└── sections/                    ← Modular sections
    ├── hero.blade.php           ← Hero slider with 3 slides
    ├── products.blade.php       ← Best selling products grid
    ├── categories.blade.php     ← Category discovery section
    ├── brand-values.blade.php   ← 3 brand value cards
    ├── inspiration.blade.php    ← Blog posts grid
    └── instagram.blade.php      ← Instagram gallery feed
```

## 🎯 Main Index File

```blade
@extends('layouts.app')

@section('content')
    @include('home.sections.hero')
    @include('home.sections.products')
    @include('home.sections.categories')
    @include('home.sections.brand-values')
    @include('home.sections.partners')
    @include('home.sections.inspiration')
    @include('home.sections.instagram')
@endsection

@push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endpush
```

## 📦 Available Data

From `HomeController@index`:

```php
$featuredProducts  // Collection - 8 featured products
$categories        // Collection - Active categories with children
$latestPosts       // Collection - 3 latest published blog posts
```

## 🔧 Editing Sections

### To Edit Hero Section
```bash
# Open
resources/views/home/sections/hero.blade.php

# Contains 3 slides:
# - Slide 1: HOA TƯƠI MỖI NGÀY
# - Slide 2: HOA NHẬP KHẨU
# - Slide 3: DỊP ĐẶC BIỆT
```

### To Edit Products Section
```bash
# Open
resources/views/home/sections/products.blade.php

# Uses: $featuredProducts from controller
# Shows: 8 products in grid
# Tabs: Bán chạy nhất, Hoa mới về, Bó hoa, Hộp hoa, Hoa nhập khẩu
```

### To Edit Categories
```bash
# Open
resources/views/home/sections/categories.blade.php

# Left side: 2 image cards (Hoa hồng, Hoa nhập khẩu)
# Right side: Category list (6 categories)
```

### To Edit Brand Values
```bash
# Open
resources/views/home/sections/brand-values.blade.php

# 3 values:
# 1. Hoa tươi được tuyển chọn mỗi ngày
# 2. Gói hoa chỉn chu, giao tận tay
# 3. Đẹp tự nhiên, trọn vẹn cảm xúc
```

### To Edit Partners
```bash
# Open

# Partners: FlowerFarm, EcoGarden, BloomCo, PetalSource, GreenValley
```

### To Edit Blog Section
```bash
# Open
resources/views/home/sections/inspiration.blade.php

# Uses: $latestPosts from controller
# Shows: 3 latest blog posts with image, title, excerpt
```

### To Edit Instagram
```bash
# Open
resources/views/home/sections/instagram.blade.php

# Shows: 5 Instagram photos
# Links to: @fello Instagram account
```

## 🎨 Adding a New Section

### 1. Create Section File
```bash
touch resources/views/home/sections/new-section.blade.php
```

### 2. Add Content
```blade
{{-- New Section --}}
<section class="new-section">
    <div class="container">
        <h2>Section Title</h2>
        {{-- Content here --}}
    </div>
</section>
```

### 3. Include in Index
```blade
@section('content')
    @include('home.sections.hero')
    @include('home.sections.products')
    @include('home.sections.new-section')  {{-- NEW --}}
    @include('home.sections.categories')
    ...
@endsection
```

### 4. Add CSS (if needed)
```bash
# Create
public/css/new-section.css

# Include in layout
resources/views/layouts/app.blade.php:
<link rel="stylesheet" href="{{ asset('css/new-section.css') }}">
```

### 5. Add JavaScript (if needed)
```javascript
// Add to public/js/home.js
(function initNewSection() {
    // Your code here
})();
```

## 🔄 Removing a Section

Remove the section include from `resources/views/home/index.blade.php` when a section is no longer needed.

## 📊 Data Requirements

### Products Section
```php
// Controller must pass:
$featuredProducts = Product::featured()->limit(8)->get();
```

### Categories Section
```php
// Controller must pass:
$categories = Category::active()->with('children')->get();
```

### Inspiration Section
```php
// Controller must pass:
$latestPosts = Post::published()->latest('published_at')->limit(3)->get();
```

## 🎯 JavaScript Functionality

Location: `public/js/home.js`

### Functions Available:
1. **initHeroSlider()** - Auto slider with 6s interval
2. **initProductTabs()** - Product category filtering
3. **initWishlist()** - Wishlist toggle functionality
4. **initBrandValuesAnimation()** - Scroll-triggered animations

### Customization:
```javascript
// Change slide duration
const SLIDE_DURATION = 6000; // ms

// Disable autoplay
// Comment out: startAutoplay();

// Change animation threshold
threshold: 0.2, // 20% visible triggers animation
```

## 🧪 Testing

### Test Homepage
```bash
php artisan serve
# Visit: http://localhost:8000
```

### Test Individual Section
```php
// Create test view
Route::get('/test-section', function () {
    return view('test', ['section' => 'home.sections.hero']);
});
```

```blade
{{-- resources/views/test.blade.php --}}
@extends('layouts.app')

@section('content')
    @include($section)
@endsection
```

## 📝 Code Style

### Blade Comments
```blade
{{-- Good: Blade comment --}}
<!-- Bad: HTML comment (visible in source) -->
```

### Loops
```blade
{{-- Good --}}
@foreach($products as $product)
    <x-product-card :product="$product" />
@endforeach

{{-- Bad: Hardcoded --}}
<div>Product 1</div>
<div>Product 2</div>
```

### Conditionals
```blade
{{-- Good --}}
@if($products->count() > 0)
    <div class="products-grid">...</div>
@endif

{{-- Bad --}}
<?php if(count($products) > 0): ?>
    <div class="products-grid">...</div>
<?php endif; ?>
```

## 🚀 Performance Tips

### 1. Lazy Load Images
```blade
<img loading="lazy" src="..." alt="..." />
```

### 2. Cache Sections
```php
// In controller
$cachedHero = Cache::remember('home.hero', 3600, function () {
    return view('home.sections.hero')->render();
});
```

### 3. Defer JavaScript
```blade
<script src="{{ asset('js/home.js') }}" defer></script>
```

## 🐛 Common Issues

### Issue: Section not showing
```bash
# Check:
1. File exists in resources/views/home/sections/
2. Filename matches @include()
3. No syntax errors in section file
4. php artisan view:clear
```

### Issue: JavaScript not working
```bash
# Check:
1. File exists in public/js/home.js
2. Asset path correct in @push('scripts')
3. Browser console for errors
4. Check if selector exists (e.g., #heroSection)
```

### Issue: Data not displaying
```bash
# Check:
1. Controller passes variable: compact('featuredProducts')
2. Variable name matches in view: $featuredProducts
3. dd($featuredProducts) to inspect data
```

## 📞 Need Help?

- Check main docs: `/REFACTORING_DONE.md`
- Check summary: `/CLEAN_CODE_SUMMARY.md`
- Check Laravel docs: https://laravel.com/docs
- Check Blade docs: https://laravel.com/docs/blade
