
<section class="inspiration-section">
    <div class="inspiration-container">
        
        <div class="inspiration-header">
            <div class="inspiration-eyebrow">GÓC NHỎ CỦA CHÚNG TÔI</div>
            <h2 class="inspiration-heading">Bài viết & Cảm hứng</h2>
            <p class="inspiration-description">Khám phá những câu chuyện thú vị về hoa, cách chăm sóc và những ý tưởng trang trí độc đáo.</p>
        </div>
        
        
        <?php if(isset($latestPosts) && $latestPosts->count() > 0): ?>
        <div class="inspiration-grid">
            <?php $__currentLoopData = $latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="blog-card">
                <div class="blog-card-image-container">
                    <img 
                        src="<?php echo e($post->image_url); ?>" 
                        alt="<?php echo e($post->title); ?>"
                        class="blog-card-image"
                        loading="lazy"
                    >
                    <span class="blog-card-category">Bài viết</span>
                </div>
                <div class="blog-card-content">
                    <h3 class="blog-card-title"><?php echo e($post->title); ?></h3>
                    <p class="blog-card-excerpt"><?php echo e(Str::limit($post->excerpt ?? $post->content, 100)); ?></p>
                        <span class="blog-card-link">
                            Xem thêm
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </span>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
        
        
        <div class="inspiration-footer">
            <a href="<?php echo e(route('blog.index')); ?>" class="inspiration-view-all">
                Xem tất cả
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\hungh\OneDrive\Documents\GitHub\FlowerShop\resources\views/home/sections/inspiration.blade.php ENDPATH**/ ?>