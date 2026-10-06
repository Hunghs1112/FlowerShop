<?php $__env->startSection('content'); ?>
<div class="admin-page">
    <h1>Đơn hàng</h1>
    <form method="GET" class="admin-filter-form">
        <input name="search" value="<?php echo e(request('search')); ?>" placeholder="Tên hoặc số điện thoại">
        <select name="status"><option value="">Tất cả trạng thái</option><option value="new">Mới</option><option value="completed">Hoàn tất</option><option value="cancelled">Đã hủy</option></select>
        <button type="submit">Lọc</button>
    </form>
    <table class="admin-table"><thead><tr><th>Mã</th><th>Khách hàng</th><th>Điện thoại</th><th>Tổng</th><th>Trạng thái</th><th></th></tr></thead><tbody>
    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr><td>#<?php echo e($order->id); ?></td><td><?php echo e($order->customer_name); ?></td><td><?php echo e($order->customer_phone); ?></td><td><?php echo e(number_format($order->total)); ?>đ</td><td><?php echo e($order->status); ?></td><td><a href="<?php echo e(route('admin.orders.show', $order)); ?>">Xem</a></td></tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?> <tr><td colspan="6">Chưa có đơn hàng.</td></tr> <?php endif; ?>
    </tbody></table>
    <?php echo e($orders->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\admin\orders\index.blade.php ENDPATH**/ ?>