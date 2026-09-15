
<section class="products-section">
    <div class="products-container">
        
        <div class="products-header">
            <h2 class="products-title">Sản phẩm nổi bật</h2>

            
            <div class="products-tabs">
                <button class="products-tab active" data-category="best-selling">Bán chạy</button>
                <button class="products-tab" data-category="new-arrival">Hoa mới</button>
                <?php $__currentLoopData = $categories->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tabCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button class="products-tab"
                            data-category="category"
                            data-category-id="<?php echo e($tabCat->id); ?>"><?php echo e($tabCat->name); ?></button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="products-divider"></div>
        </div>

        
        <div class="products-grid" id="productsGrid">
            
            <div class="products-loading">Đang tải...</div>
        </div>

        
        <div class="products-footer">
            <a href="<?php echo e(route('products.index')); ?>" class="products-view-all">
                Xem tất cả sản phẩm
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\hungh\OneDrive\Documents\GitHub\FlowerShop\resources\views/home/sections/products.blade.php ENDPATH**/ ?>