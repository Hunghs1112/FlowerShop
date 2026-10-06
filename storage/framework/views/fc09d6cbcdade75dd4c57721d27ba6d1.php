<?php $__env->startSection('page-title', 'Thêm Danh Mục Phụ'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Thêm Danh Mục Phụ</h1>
        <p class="admin-page-subtitle">Tạo danh mục phụ mới cho cửa hàng</p>
    </div>
    <div class="admin-page-actions">
        <a href="<?php echo e(route('admin.catalog.index', ['tab' => 'subcategories'])); ?>" class="btn btn-secondary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Quay Lại
        </a>
    </div>
</div>

<form action="<?php echo e(route('admin.subcategories.store')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo $__env->make('admin.subcategories.form', ['isEdit' => false], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div style="margin-top: 24px; display: flex; gap: 12px; justify-content: flex-end;">
        <a href="<?php echo e(route('admin.catalog.index', ['tab' => 'subcategories'])); ?>" class="btn btn-secondary">Hủy</a>
        <button type="submit" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Lưu Danh Mục Phụ
        </button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\admin\subcategories\create.blade.php ENDPATH**/ ?>