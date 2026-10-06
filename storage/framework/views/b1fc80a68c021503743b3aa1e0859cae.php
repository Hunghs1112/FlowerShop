

<?php $__env->startSection('title', $post->title); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginala9d931d4f11b4d2850df99e991db1dca = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala9d931d4f11b4d2850df99e991db1dca = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-hero','data' => ['title' => ''.e($post->title).'','description' => $post->excerpt ?? '','breadcrumbs' => [
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Bài viết', 'url' => route('blog.index')],
        ['label' => Str::limit($post->title, 30)]
    ],'image' => $siteBanners['blog'] ?? null,'hideOverlay' => $siteBannerHideOverlay['blog'] ?? false,'bannerKey' => 'blog']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-hero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($post->title).'','description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post->excerpt ?? ''),'breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Bài viết', 'url' => route('blog.index')],
        ['label' => Str::limit($post->title, 30)]
    ]),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($siteBanners['blog'] ?? null),'hideOverlay' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($siteBannerHideOverlay['blog'] ?? false),'banner-key' => 'blog']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala9d931d4f11b4d2850df99e991db1dca)): ?>
<?php $attributes = $__attributesOriginala9d931d4f11b4d2850df99e991db1dca; ?>
<?php unset($__attributesOriginala9d931d4f11b4d2850df99e991db1dca); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala9d931d4f11b4d2850df99e991db1dca)): ?>
<?php $component = $__componentOriginala9d931d4f11b4d2850df99e991db1dca; ?>
<?php unset($__componentOriginala9d931d4f11b4d2850df99e991db1dca); ?>
<?php endif; ?>

<div class="container page-wrapper">
    <div class="page-content">
        <!-- Post Meta -->
        <div class="post-detail-meta">
            <span class="post-meta-item">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <?php echo e($post->published_at->translatedFormat('d M, Y')); ?>

            </span>
            <span class="post-meta-item">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <?php echo e($post->getReadingTime()); ?> phút đọc
            </span>
        </div>

        <!-- Featured Image -->
        <?php if($post->thumbnail): ?>
            <div class="post-featured-image">
                <img src="<?php echo e($post->image_url); ?>" alt="<?php echo e($post->title); ?>">
            </div>
        <?php endif; ?>

        <!-- Post Content -->
        <?php if (isset($component)) { $__componentOriginal5d01bba82580f3fe260d7edec2ceb896 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5d01bba82580f3fe260d7edec2ceb896 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.markdown-renderer','data' => ['content' => $post->content]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('markdown-renderer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['content' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post->content)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5d01bba82580f3fe260d7edec2ceb896)): ?>
<?php $attributes = $__attributesOriginal5d01bba82580f3fe260d7edec2ceb896; ?>
<?php unset($__attributesOriginal5d01bba82580f3fe260d7edec2ceb896); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5d01bba82580f3fe260d7edec2ceb896)): ?>
<?php $component = $__componentOriginal5d01bba82580f3fe260d7edec2ceb896; ?>
<?php unset($__componentOriginal5d01bba82580f3fe260d7edec2ceb896); ?>
<?php endif; ?>

        <!-- Related Posts -->
        <?php if($relatedPosts->count() > 0): ?>
            <section class="related-posts">
                <h2 class="section-title">Bài viết liên quan</h2>
                <div class="blog-grid">
                    <?php $__currentLoopData = $relatedPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="post-card">
                            <?php if($relatedPost->thumbnail): ?>
                                <div class="post-card-image">
                                    <a href="<?php echo e(route('blog.show', $relatedPost->slug)); ?>">
                                        <img src="<?php echo e($relatedPost->image_url); ?>" alt="<?php echo e($relatedPost->title); ?>">
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="post-card-body">
                                <div class="post-card-meta">
                                    <span class="post-card-date">
                                        <?php echo e($relatedPost->published_at->translatedFormat('d M, Y')); ?>

                                    </span>
                                </div>
                                
                                <h3 class="post-card-title">
                                    <a href="<?php echo e(route('blog.show', $relatedPost->slug)); ?>">
                                        <?php echo e($relatedPost->title); ?>

                                    </a>
                                </h3>
                                
                                <p class="post-card-excerpt">
                                    <?php echo e(Str::limit($relatedPost->excerpt, 100)); ?>

                                </p>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>
        <?php endif; ?>

        
        <div class="post-navigation">
            <a href="<?php echo e(route('blog.index')); ?>" class="btn btn-outline">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Quay lại danh sách
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\blog\show.blade.php ENDPATH**/ ?>