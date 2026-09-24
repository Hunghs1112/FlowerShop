<?php $__env->startSection('page-title', 'Sửa Bài Viết'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-content">
    <div class="admin-header" style="margin-bottom: 32px;">
        <div>
            <h1 class="admin-title">Sửa Bài Viết</h1>
            <p style="color: var(--admin-text-secondary); font-size: 14px; margin-top: 4px;">
                <span style="display: inline-flex; align-items: center; gap: 6px;">
                    <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></span>
                    Tự động lưu đã bật
                </span>
            </p>
        </div>
        <a href="<?php echo e(route('admin.posts.index')); ?>" class="btn btn-outline">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay Lại
        </a>
    </div>

    <div id="post-form" data-entity="posts" data-id="<?php echo e($post->id); ?>">
        <?php echo $__env->make('admin.posts.form', ['isEdit' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/FlowerShop/resources/views/admin/posts/edit.blade.php ENDPATH**/ ?>