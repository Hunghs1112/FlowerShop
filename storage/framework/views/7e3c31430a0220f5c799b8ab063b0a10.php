
<section class="categories-section">
    <div class="container">
        <div class="categories-section-header">
            <span class="categories-section-label"><?php echo e(content('categories_label', 'Danh mục sản phẩm')); ?></span>
            <h2 class="categories-section-title"><?php echo e(content('categories_title', 'Khám Phá Bộ Sưu Tập')); ?></h2>
        </div>

        <div class="categories-grid">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('products.index', ['categories' => [$category->id]])); ?>" class="category-card">
                    <?php if($category->image): ?>
                        <img
                            src="<?php echo e($category->image_url); ?>"
                            alt="<?php echo e($category->display_name); ?>"
                            class="category-card-image category-card-image-default"
                            loading="lazy"
                        >
                        <?php if($category->hover_image): ?>
                            <img
                                src="<?php echo e($category->hover_image_url); ?>"
                                alt="<?php echo e($category->display_name); ?>"
                                class="category-card-image category-card-image-hover"
                                loading="lazy"
                            >
                        <?php endif; ?>
                    <?php else: ?>
                        <img
                            src="<?php echo e(asset('images/categories/placeholder.jpg')); ?>"
                            alt="<?php echo e($category->display_name); ?>"
                            class="category-card-image"
                            loading="lazy"
                        >
                    <?php endif; ?>
                    
                    <div class="category-card-overlay"></div>
                    
                    <div class="category-card-content">
                        <h3 class="category-card-title"><?php echo e($category->display_name); ?></h3>
                        <span class="category-card-count"><?php echo e($category->products_count ?? $category->products()->count()); ?> <?php echo e(content('categories_products_suffix', 'sản phẩm')); ?></span>
                        <span class="category-card-link">
                            <span><?php echo e(content('categories_explore', 'Khám phá')); ?></span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </span>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php /**PATH D:\Github\FlowerShop\resources\views\home\sections\categories.blade.php ENDPATH**/ ?>