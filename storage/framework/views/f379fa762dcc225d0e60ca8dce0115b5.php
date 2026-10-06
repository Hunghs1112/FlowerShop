<?php $__env->startSection('title', 'Sửa loài hoa'); ?>
<?php $__env->startSection('content'); ?>
<div class="admin-page-header"><div class="admin-page-header-left"><h1 class="admin-page-title">Sửa loài hoa</h1></div><a href="<?php echo e(route('admin.flower-origins.index')); ?>" class="btn btn-secondary">Quay lại</a></div>
<form action="<?php echo e(route('admin.flower-origins.update', $item)); ?>" method="POST" enctype="multipart/form-data"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?> <?php echo $__env->make('admin.flower-origins.form', ['item' => $item], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\admin\flower-origins\edit.blade.php ENDPATH**/ ?>