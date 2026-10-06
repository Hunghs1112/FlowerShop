<?php $__env->startSection('title', 'Danh mục sản phẩm'); ?>


<?php $__env->startSection('content'); ?>
<!-- Hero Banner -->
<section class="categories-hero" style="--banner-height-desktop: <?php echo e($siteBannerSizes['categories']['desktop']); ?>px; --banner-height-mobile: <?php echo e($siteBannerSizes['categories']['mobile']); ?>px;">
    <img
        src="<?php echo e($siteBanners['categories'] ?? asset('images/banners/danh-muc-hero.jpg')); ?>"
        alt="Danh mục sản phẩm"
        class="categories-hero-image"
    >
    <?php if (! ($siteBannerHideOverlay['categories'] ?? false)): ?>
    <div class="categories-hero-overlay"></div>
    <?php endif; ?>
    <div class="categories-hero-content">
        <h1 class="categories-hero-heading">Danh mục sản phẩm</h1>
        <p class="categories-hero-description">Khám phá các danh mục hoa tươi đa dạng của chúng tôi</p>
    </div>
</section>

<!-- Categories Grid -->
<section class="categories-index-section">
    <div class="categories-index-grid">
        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('categories.show', $category->display_slug)); ?>" class="category-card">
            <img
                src="<?php echo e($category->image ? $category->image_url : asset('images/categories/category-default.jpg')); ?>"
                alt="<?php echo e($category->display_name); ?>"
                class="category-card-image"
            >
            <div class="category-card-overlay">
                <h3 class="category-card-name"><?php echo e($category->display_name); ?></h3>
                <p class="category-card-count"><?php echo e($category->products_count ?? 0); ?> sản phẩm</p>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="categories-empty">
            <p>Không có danh mục nào.</p>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\categories\index.blade.php ENDPATH**/ ?>