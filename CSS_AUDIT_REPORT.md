# CSS Consistency Audit Report - FlowerShop

**Date:** September 16, 2026
**Scope:** 62 Blade view files, 41 CSS source files

---

## Executive Summary

| Metric | Count |
|--------|-------|
| Unique CSS classes used in views | 682 |
| Unique CSS classes defined in CSS | 754 |
| Unique IDs used in views | 41 |
| Unique IDs defined in CSS | 0 |
| **Missing CSS definitions (Critical)** | ~70 |
| **Unused CSS classes (Low priority)** | ~72 |
| **Naming convention issues** | Multiple |

---

## 🔴 CRITICAL: Classes Used But NOT Defined in CSS

These classes are used in views but have NO corresponding CSS definition.

### 1. Profile/Account Pages (~20 classes)

| Class | Used In | Status |
|-------|---------|--------|
| `.account-layout` | `profile/show.blade.php:17` | ❌ MISSING |
| `.account-sidebar` | `profile/show.blade.php:19` | ❌ MISSING |
| `.account-user` | `profile/show.blade.php:20` | ❌ MISSING |
| `.account-avatar` | `profile/show.blade.php:21` | ❌ MISSING |
| `.account-user-info` | `profile/show.blade.php:24` | ❌ MISSING |
| `.account-nav` | `profile/show.blade.php:30` | ❌ MISSING |
| `.account-nav-item` | `profile/show.blade.php:31,39` | ❌ MISSING |
| `.account-main` | `profile/show.blade.php:50` | ❌ MISSING |
| `.account-card` | `profile/show.blade.php:52,116,159` | ❌ MISSING |
| `.account-card-header` | `profile/show.blade.php:53,117,160` | ❌ MISSING |
| `.account-card-title` | `profile/show.blade.php:54,118,161` | ❌ MISSING |
| `.account-card-body` | `profile/show.blade.php:56,120,163` | ❌ MISSING |
| `.inquiry-list` | `profile/show.blade.php:165` | ❌ MISSING |
| `.inquiry-item` | `profile/show.blade.php:167` | ❌ MISSING |
| `.inquiry-header` | `profile/show.blade.php:168` | ❌ MISSING |
| `.inquiry-id` | `profile/show.blade.php:169` | ❌ MISSING |
| `.inquiry-meta` | `profile/show.blade.php:174` | ❌ MISSING |
| `.inquiry-message` | `profile/show.blade.php:180` | ❌ MISSING |
| `.inquiry-products` | `profile/show.blade.php:182` | ❌ MISSING |
| `.inquiry-product` | `profile/show.blade.php:184` | ❌ MISSING |

**Action:** Create `public/css/account.css`

### 2. Cart Page Layout - MAJOR INCONSISTENCY (~18 classes)

**CRITICAL ISSUE:** Cart view uses different class names than what `cart.css` defines!

| Class Used in Views | CSS Definition Exists? | CSS Alternative |
|--------------------|------------------------|----------------|
| `.checkout-layout` | ❌ NO | `.cart-container` exists in CSS |
| `.checkout-main` | ❌ NO | `.cart-items` exists in CSS |
| `.checkout-sidebar` | ❌ NO | `.cart-summary` exists in CSS |
| `.cart-items-card` | ❌ NO | `.cart-items` exists in CSS |
| `.cart-card-header` | ❌ NO | `.cart-items-header` exists in CSS |
| `.cart-card-title` | ❌ NO | `.cart-items-title` exists in CSS |
| `.cart-card-body` | ❌ NO | (part of cart-items) |
| `.cart-item-category` | ❌ NO | `.cart-item-meta` exists in CSS |
| `.cart-item-total` | ❌ NO | `.cart-item-price-total` exists in CSS |
| `.cart-item-actions` | ❌ NO | `.cart-item-controls` exists in CSS |
| `.quantity-form` | ❌ NO | (inline form) |
| `.qty-input` | ❌ NO | `.cart-item-quantity-input` exists |
| `.cart-actions` | ❌ NO | (missing) |
| `.cart-actions-left` | ❌ NO | (missing) |
| `.cart-actions-right` | ❌ NO | (missing) |
| `.btn-remove` | ❌ NO | `.cart-item-remove` exists |
| `.checkout-note` | ❌ NO | `.cart-summary-note` exists |
| `.checkout-btn` | ❌ NO | (missing) |

**Root Cause:** The cart view was rewritten but CSS was not updated to match.

**Action:** Either update cart view to use existing CSS classes, OR add missing CSS definitions to `cart.css`.

### 3. Checkout Page Classes (~15 classes)

| Class | Used In | CSS Has Similar? |
|-------|---------|-----------------|
| `.checkout-card` | `checkout/index.blade.php:26` | `.checkout-form` exists |
| `.checkout-card-header` | `checkout/index.blade.php:27` | `.checkout-section` exists |
| `.checkout-card-icon` | `checkout/index.blade.php:28,112` | ❌ MISSING |
| `.checkout-card-title` | `checkout/index.blade.php:33` | ❌ MISSING |
| `.checkout-card-body` | `checkout/index.blade.php:35` | ❌ MISSING |
| `.checkout-actions` | `checkout/index.blade.php:91` | ❌ MISSING |
| `.order-summary-card` | `checkout/index.blade.php:110` | `.checkout-summary` exists |
| `.summary-card-header` | `checkout/index.blade.php:111` | ❌ MISSING |
| `.summary-card-body` | `checkout/index.blade.php:119` | ❌ MISSING |
| `.summary-card-title` | `checkout/index.blade.php:117` | ❌ MISSING |
| `.summary-items` | `checkout/index.blade.php:120` | ❌ MISSING |
| `.summary-item` | `checkout/index.blade.php:121` | ❌ MISSING |
| `.summary-item-image` | `checkout/index.blade.php:123` | ❌ MISSING |
| `.summary-item-info` | `checkout/index.blade.php:127` | ❌ MISSING |
| `.summary-item-name` | `checkout/index.blade.php:128` | ❌ MISSING |
| `.summary-item-qty` | `checkout/index.blade.php:129` | ❌ MISSING |
| `.summary-item-price` | `checkout/index.blade.php:131` | ❌ MISSING |
| `.item-quantity-badge` | `checkout/index.blade.php:125` | ❌ MISSING |
| `.info-item` | `checkout/index.blade.php:156,167` | ❌ MISSING |
| `.checkout-info` | `checkout/index.blade.php:155` | ❌ MISSING |

**Action:** Add missing classes to `checkout.css`

### 4. Products Filter Classes (~8 classes)

| Class | Used In | Status |
|-------|---------|--------|
| `.products-filter-body` | `products/index.blade.php:155` | ❌ MISSING |
| `.products-filter-close` | `products/index.blade.php:148` | ❌ MISSING |
| `.products-filter-form` | `products/index.blade.php:142` | ❌ MISSING |
| `.products-filter-overlay` | `products/index.blade.php:144` | ❌ MISSING |
| `.products-filter-search-input` | `products/index.blade.php:164` | ❌ MISSING |
| `.products-filter-checkbox` | `products/index.blade.php:184,211,251` | ❌ MISSING |
| `.products-sort-dropdown` | `products/index.blade.php:97` | ❌ MISSING |
| `.products-sort-item` | `products/index.blade.php:116,120,124,128,132` | ❌ MISSING |

**Action:** Add to `products/filter.css` and `products/toolbar.css`

### 5. Product Detail Page Classes (~10 classes)

| Class | Used In | Status |
|-------|---------|--------|
| `.product-card-badge` | `products/detail.blade.php:259,290` | ❌ MISSING |
| `.product-card-category` | `products/detail.blade.php:263,294` | ❌ MISSING |
| `.product-card-content` | `products/detail.blade.php:262,293` | ❌ MISSING |
| `.product-card-image` | `products/detail.blade.php:256,287` | ❌ MISSING |
| `.product-card-price` | `products/detail.blade.php:265,296` | ❌ MISSING |
| `.product-card-title` | `products/detail.blade.php:264,295` | ❌ MISSING |
| `.product-card--small` | `products/detail.blade.php:286` | ❌ MISSING |
| `.discount-badge` | `products/detail.blade.php:45` | ❌ MISSING |
| `.card-price-sale` | `products/detail.blade.php:268,299` | ❌ MISSING |
| `.card-price-original` | `products/detail.blade.php:266,297` | ❌ MISSING |
| `.recommended` | `products/detail.blade.php:250` | ❌ MISSING |
| `.recently-viewed` | `products/detail.blade.php:281` | ❌ MISSING |
| `.products-grid-small` | `products/detail.blade.php:284` | ❌ MISSING |
| `.back-to-top` | `products/detail.blade.php:312` | ❌ MISSING |

**Note:** Product detail uses non-BEM naming (`.product-card-*`) while `product-card.css` uses BEM (`.product-card__*`)

### 6. Admin Layout Classes (~5 classes)

| Class | Used In | Status |
|-------|---------|--------|
| `.admin-header` | `admin/*/edit.blade.php:7` | ❌ MISSING |
| `.admin-title` | `admin/*/edit.blade.php:8` | ❌ MISSING |
| `.admin-page-header-left` | `admin/*/create.blade.php:7` | ❌ MISSING |

**Action:** Add to `admin.css`

### 7. Zalo-Related Classes (~10 classes)

| Class | Used In | Status |
|-------|---------|--------|
| `.zalo-section` | `pages/contact.blade.php:153` | ❌ MISSING |
| `.zalo-info-card` | `components/zalo-info.blade.php:10` | ❌ MISSING |
| `.zalo-info-header` | `components/zalo-info.blade.php:11` | ❌ MISSING |
| `.zalo-title` | `components/zalo-info.blade.php:17` | ❌ MISSING |
| `.zalo-subtitle` | `components/zalo-info.blade.php:18` | ❌ MISSING |
| `.zalo-benefits` | `components/zalo-info.blade.php:23` | ❌ MISSING |
| `.zalo-info-content` | `components/zalo-info.blade.php:22` | ❌ MISSING |
| `.zalo-qr-section` | `components/zalo-info.blade.php:45` | ❌ MISSING |
| `.zalo-qr-code` | `components/zalo-info.blade.php:47` | ❌ MISSING |
| `.btn-zalo` | `components/zalo-info.blade.php:51` | ❌ MISSING |

**Action:** Create `public/css/zalo.css`

### 8. Misc. Missing Classes (~10 classes)

| Class | Used In | Status |
|-------|---------|--------|
| `.about-layout` | `pages/about.blade.php:18` | ❌ MISSING |
| `.page-body` | `pages/policy.blade.php:19` | ❌ MISSING |
| `.page-body-content` | `pages/about.blade.php:22` | ❌ MISSING |
| `.page-content` | `pages/policy.blade.php:18` | ❌ MISSING |
| `.page-content-narrow` | `blog/show.blade.php:18` | ❌ MISSING |
| `.section-header` | `products/detail.blade.php:252,283` | ❌ MISSING |
| `.section-title` | `blog/show.blade.php:72` | ❌ MISSING |
| `.related-posts` | `blog/show.blade.php:71` | ❌ MISSING |
| `.gallery-item` | `products/detail.blade.php:38,52` | ❌ MISSING |
| `.empty-text` | `products/detail.blade.php:274,305` | ❌ MISSING |

### 9. Auth Password Reset Pages (~3 classes)

| Class | Used In | Status |
|-------|---------|--------|
| `.auth-page` | `auth/passwords/email.blade.php:6` | ❌ MISSING |
| `.auth-links` | `auth/passwords/email.blade.php:41` | ❌ MISSING |
| `.auth-logo` | `auth/passwords/email.blade.php:8` | ❌ MISSING |

---

## 🟡 HIGH: Naming Convention Issues

### BEM vs Non-BEM Inconsistency

The project uses BEM convention in some places but non-BEM in others:

**BEM (Correct - used in `product-card.css`):**
```css
.product-card__badge
.product-card__category
.product-card__image
.product-card__price
.product-card__name
```

**Non-BEM (Inconsistent - used in `products/detail.blade.php`):**
```html
.product-card-badge
.product-card-category
.product-card-image
.product-card-price
.product-card-title
```

**Recommendation:** Standardize on BEM. Update `products/detail.blade.php` to use BEM classes.

### Cart Page Major Naming Mismatch

| View Uses | CSS Defines |
|-----------|------------|
| `.checkout-layout` | `.cart-container` |
| `.checkout-main` | `.cart-items` |
| `.checkout-sidebar` | `.cart-summary` |
| `.cart-card-header` | `.cart-items-header` |
| `.btn-remove` | `.cart-item-remove` |
| `.checkout-note` | `.cart-summary-note` |

**Recommendation:** Either:
1. Update cart view to use existing CSS classes, OR
2. Add CSS definitions for the new class names

---

## 🔵 LOW: Unused CSS Classes

These classes are defined in CSS but NOT used in any view.

### From `buttons.css`:
- `.btn-ghost`, `.btn-text`, `.btn-icon-sm`, `.btn-icon-lg`, `.btn-xl`, `.btn-group`, `.btn-loading`

### From `badges.css`:
- `.badge-primary-light`, `.badge-secondary-light`, `.badge-accent-light`, `.badge-success-light`, `.badge-warning-light`, `.badge-error-light`, `.badge-outline`, `.badge-outline-primary`, `.badge-outline-secondary`, `.badge-sm`, `.badge-lg`, `.badge-featured`, `.badge-new`, `.badge-bestseller`, `.badge-stock-low`, `.badge-stock-out`, `.badge-dot`, `.badge-icon`, `.badge-pill`, `.badge-group`, `.badge-discount`, `.badge-notification`, `.badge-notification-sm`

### From `cart.css`:
- `.cart-page`, `.cart-container`, `.cart-items`, `.cart-items-header`, `.cart-items-title`, `.cart-items-count`, `.cart-item`, `.cart-item-image`, `.cart-item-info`, `.cart-item-name`, `.cart-item-meta`, `.cart-item-controls`, `.cart-item-quantity`, `.cart-item-quantity-btn`, `.cart-item-quantity-input`, `.cart-item-remove`, `.cart-item-price`, `.cart-item-price-unit`, `.cart-item-price-total`, `.cart-summary`, `.cart-summary-title`, `.cart-summary-row`, `.cart-summary-label`, `.cart-summary-value`, `.cart-summary-divider`, `.cart-summary-total`, `.cart-summary-total-label`, `.cart-summary-total-value`, `.cart-summary-actions`, `.cart-summary-note`, `.cart-empty`, `.cart-empty-icon`, `.cart-empty-title`, `.cart-empty-description`

### From `checkout.css`:
- `.checkout-page`, `.checkout-container`, `.checkout-form`, `.checkout-section`, `.checkout-section-title`, `.checkout-summary`

### From `layout.css` (utility classes):
- `.container-fluid`, `.container-narrow`, `.section-sm`, `.section-lg`, `.grid-2`, `.grid-3`, `.grid-4`, `.grid-auto`, `.flex`, `.flex-center`, `.flex-between`, `.flex-col`, `.flex-wrap`, `.gap-*`

### From `admin/tables.css`:
- `.admin-table-actions`, `.admin-table-action`, `.admin-table-product`, `.admin-table-product-image`, `.admin-table-product-info`, `.admin-table-product-name`, `.admin-table-product-meta`, `.admin-table-pagination`, `.admin-table-pagination-info`, `.admin-table-pagination-buttons`

### From `product-card.css`:
- `.product-card__price-old`, `.product-card__discount`, `.product-card__rating`, `.product-card__stars`, `.product-card__rating-count`, `.product-card__stock`, `.product-card__stock--in-stock`, `.product-card__stock--low-stock`, `.product-card__stock--out-of-stock`, `.product-card__stock-dot`

### From `typography.css`:
- `.text-xs`, `.text-lg`, `.text-xl`, `.label`, `.label-sm`, `.price`, `.price-lg`, `.price-sm`, `.price-old`, `.text-primary`, `.text-secondary`, `.text-accent`, `.text-light`, `.text-lighter`, `.uppercase`, `.font-serif`, `.font-sans`, `.editorial-heading`, `.editorial-subheading`, `.editorial-caption`

### From `products/filter.css`:
- `.products-filter-reset`, `.filter-group`, `.filter-group-toggle`, `.filter-group-content`, `.filter-option-count`, `.filter-colors`, `.filter-color`, `.products-filter-mobile-toggle`, `.products-filter-drawer`, `.products-filter-drawer-backdrop`

### From `products/grid.css`:
- `.products-grid--2-cols`, `.products-grid--3-cols`, `.products-grid--4-cols`, `.products-grid--list`, `.products-loading`, `.products-loading-spinner`

### From `products/toolbar.css`:
- `.products-sort-label`, `.products-sort-select`, `.products-view-toggle`, `.products-view-btn`

---

## 📋 Priority Recommendations

### 🚨 CRITICAL (Fix Immediately)

1. **Fix Cart Page Layout Mismatch**
   - Cart view uses `.checkout-layout`, `.checkout-main`, `.checkout-sidebar`
   - CSS has `.cart-container`, `.cart-items`, `.cart-summary`
   - Either update view or add CSS definitions
   - **Files affected:** `cart/index.blade.php`, `cart.css`

2. **Create `public/css/account.css`**
   - Add all `.account-*` and `.inquiry-*` classes
   - **Files affected:** `profile/show.blade.php`

### 🟡 HIGH (Fix Soon)

3. **Add Missing Checkout Classes to `checkout.css`**
   - `.checkout-card-*`, `.order-summary-card`, `.summary-card-*`
   - **Files affected:** `checkout/index.blade.php`, `checkout.css`

4. **Add Missing Filter Classes**
   - Add to `products/filter.css` and `products/toolbar.css`
   - **Files affected:** `products/index.blade.php`

5. **Add Product Detail Classes**
   - Either create non-BEM definitions or convert to BEM
   - **Files affected:** `products/detail.blade.php`

### 🟢 MEDIUM (Plan for Later)

6. **Clean Up Unused CSS Classes**
   - 72+ classes defined but not used
   - Can be removed after verification

7. **Create `public/css/zalo.css`**
   - Add all `.zalo-*` classes
   - **Files affected:** `zalo-info.blade.php`

---

## 📁 Files Needing Updates

| Priority | File | Action |
|----------|------|--------|
| 🔴 | `cart/index.blade.php` | Fix class naming to match CSS |
| 🔴 | `public/css/cart.css` | Add missing cart view classes |
| 🔴 | `public/css/account.css` | Create new file with account styles |
| 🟡 | `public/css/checkout.css` | Add missing checkout classes |
| 🟡 | `public/css/products/filter.css` | Add missing filter classes |
| 🟡 | `public/css/products/toolbar.css` | Add missing toolbar classes |
| 🟡 | `public/css/products/detail.css` | Add missing detail classes |
| 🟡 | `public/css/admin.css` | Add missing admin classes |
| 🟢 | `public/css/zalo.css` | Create for Zalo styling |
| 🟢 | Various | Remove unused CSS classes |

---

## Summary Statistics

- **Total CSS files:** 41
- **Total Blade view files:** 62
- **Missing CSS definitions:** ~70 classes
- **Major naming mismatches:** 2 (cart, checkout)
- **Naming convention issues:** ~15 classes
- **Unused CSS classes:** ~72 classes
- **Files needing updates:** ~12 files

**Estimated effort:** 4-6 hours to fix all critical and high priority issues.
