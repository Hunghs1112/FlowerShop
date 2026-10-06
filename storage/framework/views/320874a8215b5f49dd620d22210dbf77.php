<?php $__env->startSection('page-title', 'Thêm Người Dùng'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Thêm Người Dùng Mới</h1>
        <p class="admin-page-subtitle">Tạo tài khoản người dùng mới</p>
    </div>
    <div class="admin-page-actions">
        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay Lại
        </a>
    </div>
</div>

<form action="<?php echo e(route('admin.users.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo $__env->make('admin.users.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\admin\users\create.blade.php ENDPATH**/ ?>