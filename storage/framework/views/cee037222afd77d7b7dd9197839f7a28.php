<?php $__env->startSection('content'); ?>
<div class="admin-page">
    <a href="<?php echo e(route('admin.orders.index')); ?>">← Đơn hàng</a>
    <h1>Đơn hàng #<?php echo e($order->id); ?></h1>
    <p><strong><?php echo e($order->customer_name); ?></strong> · <?php echo e($order->customer_phone); ?> · <?php echo e($order->customer_email); ?></p>
    <table class="admin-table"><thead><tr><th>Sản phẩm</th><th>SKU</th><th>SL</th><th>Đơn giá</th><th>Thành tiền</th></tr></thead><tbody>
    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr><td><?php echo e($item->product_name); ?><?php echo e($item->variant_name ? ' - '.$item->variant_name : ''); ?></td><td><?php echo e($item->sku); ?></td><td><?php echo e($item->quantity); ?></td><td><?php echo e(number_format($item->unit_price)); ?>đ</td><td><?php echo e(number_format($item->subtotal)); ?>đ</td></tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody></table>
    <p><strong>Tổng: <?php echo e(number_format($order->total)); ?>đ</strong></p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\admin\orders\show.blade.php ENDPATH**/ ?>