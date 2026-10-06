<?php $__env->startSection('title', $category->display_name); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Banner -->
<section class="products-hero <?php echo e($category->hide_banner_content ? 'products-hero--image-only' : ''); ?>" style="--banner-height-desktop: <?php echo e($siteBannerSizes['categories']['desktop']); ?>px; --banner-height-mobile: <?php echo e($siteBannerSizes['categories']['mobile']); ?>px;">
    <img 
        src="<?php echo e($category->banner_image ? $category->banner_image_url : ($category->image ? $category->image_url : ($siteBanners['categories'] ?? asset('images/banners/danh-muc-hero.jpg')))); ?>" 
        alt="<?php echo e($category->display_name); ?>"
        class="products-hero-image"
    >
    <?php if (! ($category->hide_banner_content || ($siteBannerHideOverlay['categories'] ?? false))): ?>
    <div class="products-hero-overlay"></div>
    <div class="products-hero-content">
        <div class="products-breadcrumb">
            <a href="<?php echo e(route('home')); ?>">Trang chủ</a>
            <span>/</span>
            <a href="<?php echo e(route('categories.index')); ?>">Danh mục</a>
            <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span>/</span>
            <?php if($loop->last): ?>
            <span><?php echo e($item['name']); ?></span>
            <?php else: ?>
            <a href="<?php echo e($item['url']); ?>"><?php echo e($item['name']); ?></a>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <h1 class="products-hero-heading"><?php echo e($category->display_name); ?></h1>
        <?php if($category->display_description): ?>
        <p class="products-hero-description"><?php echo e($category->display_description); ?></p>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</section>

<!-- Subcategories -->
<?php if($category->children && $category->children->count() > 0): ?>
<section class="subcategories-bar">
    <div class="subcategories-inner">
        <h3 class="subcategories-title">Danh mục con</h3>
        <div class="subcategories-list">
            <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('categories.show', $child->slug)); ?>" class="subcategory-link">
                <?php echo e($child->display_name); ?>

            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

    <!-- Toolbar -->
<section class="products-toolbar">
    <div class="products-toolbar-left">
        <button class="products-filter-button" id="filterToggle">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            Lọc
        </button>
        <span class="products-count">
            <?php echo e(content('products_showing', 'Hiển thị')); ?> <?php echo e($products->count()); ?> / <?php echo e($products->total()); ?> <?php echo e(content('products_suffix', 'sản phẩm')); ?>

        </span>
    </div>
    
    <div class="products-toolbar-right">
        <div class="products-sort-dropdown">
            <button class="products-sort-button" id="sortToggle">
                <span>Sắp xếp: <span id="sortLabel">
                    <?php switch($filters['sort_by'] ?? 'latest'):
                        case ('price_asc'): ?> Giá: Thấp đến cao <?php break; ?>
                        <?php case ('price_desc'): ?> Giá: Cao đến thấp <?php break; ?>
                        <?php case ('name'): ?> Tên A-Z <?php break; ?>
                        <?php default: ?> Mới nhất
                    <?php endswitch; ?>
                </span></span>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div class="products-sort-menu" id="sortMenu">
                <a href="<?php echo e(request()->fullUrlWithQuery(['sort_by' => 'latest'])); ?>" class="products-sort-item <?php echo e(($filters['sort_by'] ?? 'latest') === 'latest' ? 'active' : ''); ?>">Mới nhất</a>
                <a href="<?php echo e(request()->fullUrlWithQuery(['sort_by' => 'price_asc'])); ?>" class="products-sort-item <?php echo e(($filters['sort_by'] ?? '') === 'price_asc' ? 'active' : ''); ?>">Giá: Thấp đến cao</a>
                <a href="<?php echo e(request()->fullUrlWithQuery(['sort_by' => 'price_desc'])); ?>" class="products-sort-item <?php echo e(($filters['sort_by'] ?? '') === 'price_desc' ? 'active' : ''); ?>">Giá: Cao đến thấp</a>
                <a href="<?php echo e(request()->fullUrlWithQuery(['sort_by' => 'name'])); ?>" class="products-sort-item <?php echo e(($filters['sort_by'] ?? '') === 'name' ? 'active' : ''); ?>">Tên A-Z</a>
            </div>
        </div>
    </div>
</section>

<!-- Filter Sidebar -->
<div class="products-filter-overlay" id="filterOverlay"></div>
<aside class="products-filter-sidebar" id="filterSidebar">
    <div class="products-filter-header">
        <h3 class="products-filter-title">Lọc</h3>
        <button class="products-filter-close" id="filterClose">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    
    <form action="<?php echo e(route('categories.show', $category->slug)); ?>" method="GET" id="filterForm">
        <div class="products-filter-body">
            <!-- Khoảng giá -->
            <div class="products-filter-group">
                <h4 class="products-filter-group-title">Khoảng giá</h4>
                <div class="products-filter-options">
                    <div class="filter-price-group">
                        <input type="number" name="min_price" placeholder="Từ" value="<?php echo e($filters['min_price'] ?? ''); ?>"
                               class="filter-price-input">
                        <input type="number" name="max_price" placeholder="Đến" value="<?php echo e($filters['max_price'] ?? ''); ?>"
                               class="filter-price-input">
                    </div>
                </div>
            </div>
            
            <!-- Còn hàng -->
            <div class="products-filter-group">
                <label class="products-filter-option">
                    <input type="checkbox" name="in_stock" value="1" <?php echo e(($filters['in_stock'] ?? false) ? 'checked' : ''); ?> class="products-filter-checkbox">
                    <span class="products-filter-label">Chỉ hiển thị sản phẩm còn hàng</span>
                </label>
            </div>
        </div>
        
        <div class="products-filter-footer">
            <a href="<?php echo e(route('categories.show', $category->slug)); ?>" class="products-filter-clear">Đặt lại</a>
            <button type="submit" class="products-filter-apply">Áp dụng</button>
        </div>
    </form>
</aside>

<!-- Products Grid -->
<section class="products-grid-section">
    <div class="products-grid-container">
        <div class="products-grid" id="productsGrid">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="products-empty">
                <p>Không có sản phẩm nào.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter sidebar toggle
    const filterToggle = document.getElementById('filterToggle');
    const filterSidebar = document.getElementById('filterSidebar');
    const filterOverlay = document.getElementById('filterOverlay');
    const filterClose = document.getElementById('filterClose');
    
    function openFilter() {
        filterSidebar.classList.add('active');
        filterOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeFilter() {
        filterSidebar.classList.remove('active');
        filterOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    filterToggle.addEventListener('click', openFilter);
    filterClose.addEventListener('click', closeFilter);
    filterOverlay.addEventListener('click', closeFilter);
    
    // Sort dropdown toggle
    const sortToggle = document.getElementById('sortToggle');
    const sortMenu = document.getElementById('sortMenu');
    
    sortToggle.addEventListener('click', function(e) {
        e.stopPropagation();
        sortToggle.classList.toggle('active');
        sortMenu.classList.toggle('active');
    });
    
    document.addEventListener('click', function(e) {
        if (!sortToggle.contains(e.target) && !sortMenu.contains(e.target)) {
            sortToggle.classList.remove('active');
            sortMenu.classList.remove('active');
        }
    });
});

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\categories\show.blade.php ENDPATH**/ ?>