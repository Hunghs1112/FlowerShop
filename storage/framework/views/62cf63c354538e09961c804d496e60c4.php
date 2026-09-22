
<section class="inspiration-section">
    <div class="container">
        
        <div class="inspiration-section-header">
            <span class="inspiration-section-label"><?php echo e(content('inspiration_label', 'Góc nhỏ của chúng tôi')); ?></span>
            <h2 class="inspiration-section-title"><?php echo e(content('inspiration_title', 'Bài Viết & Cảm Hứng')); ?></h2>
            <p class="inspiration-section-description">
                <?php echo e(content('inspiration_description', 'Khám phá những câu chuyện thú vị về hoa, cách chăm sóc và những ý tưởng trang trí độc đáo.')); ?>

            </p>
        </div>
        
        
        <?php if(isset($latestPosts) && $latestPosts->count() > 0): ?>
        <div class="inspiration-grid">
            <?php $__currentLoopData = $latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="inspiration-card">
                <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="inspiration-card-image-link">
                    <img 
                        src="<?php echo e($post->image_url); ?>" 
                        alt="<?php echo e($post->title); ?>"
                        class="inspiration-card-image"
                        loading="lazy"
                        width="600"
                        height="400"
                    >
                    <span class="inspiration-card-badge"><?php echo e(content('inspiration_badge', 'Bài viết')); ?></span>
                </a>
                <div class="inspiration-card-content">
                    <time class="inspiration-card-date"><?php echo e($post->created_at->format('d/m/Y')); ?></time>
                    <h3 class="inspiration-card-title">
                        <a href="<?php echo e(route('blog.show', $post->slug)); ?>"><?php echo e($post->title); ?></a>
                    </h3>
                    <p class="inspiration-card-excerpt"><?php echo e(Str::limit($post->excerpt ?? strip_tags($post->content), 120)); ?></p>
                    <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="inspiration-card-link">
                        <?php echo e(content('inspiration_read_more', 'Đọc tiếp')); ?>

                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
        
        
        <div class="inspiration-section-footer">
            <a href="<?php echo e(route('blog.index')); ?>" class="btn btn-outline">
                <?php echo e(content('inspiration_view_all', 'Xem tất cả bài viết')); ?>

                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\hungh\OneDrive\Documents\GitHub\FlowerShop\resources\views/home/sections/inspiration.blade.php ENDPATH**/ ?>