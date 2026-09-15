
<section class="categories-section">
    <div class="categories-container">
        
        <div class="categories-images">
            <?php $__currentLoopData = $categories->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $catCard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('categories.show', $catCard->display_slug)); ?>" class="category-image-card">
                <?php if($catCard->image): ?>
                    <img
                        src="<?php echo e(asset($catCard->image)); ?>"
                        alt="<?php echo e($catCard->display_name); ?>"
                        loading="lazy"
                    >
                <?php else: ?>
                    <img
                        src="<?php echo e(asset('images/categories/' . $catCard->slug . '.jpg')); ?>"
                        alt="<?php echo e($catCard->display_name); ?>"
                        loading="lazy"
                    >
                <?php endif; ?>
                <div class="category-image-overlay"></div>
                <div class="category-image-content">
                    <h3 class="category-image-title"><?php echo e(Str::upper($catCard->display_name)); ?></h3>
                    <p class="category-image-count"><?php echo e($catCard->products_count ?? $catCard->products()->count()); ?>+ sản phẩm</p>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="categories-content">
            <span class="categories-label">DANH MỤC SẢN PHẨM</span>
            <h2 class="categories-heading">Khám phá bộ sưu tập</h2>
            <div class="categories-heading-decoration"></div>

            <ul class="categories-list">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="category-list-item">
                        <a href="<?php echo e(route('categories.show', $cat->display_slug)); ?>" class="category-list-link">
                            <span class="category-list-name"><?php echo e($cat->display_name); ?></span>
                            <div class="category-list-arrow">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\hungh\OneDrive\Documents\GitHub\FlowerShop\resources\views/home/sections/categories.blade.php ENDPATH**/ ?>