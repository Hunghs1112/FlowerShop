

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng mới #<?php echo e($orderId); ?> - Lâm Nhiên Thảo</title>
</head>
<body>
    <div class="email-wrapper">
        
        <div class="email-header">
            <h1>🆕 ĐƠN HÀNG MỚI</h1>
            <p class="subtitle">Lâm Nhiên Thảo - Flowers & Gifts</p>
            <div class="alert-badge">Cần xử lý</div>
        </div>

        
        <div class="email-body">
            
            <div class="section">
                <div>
                    <span>#<?php echo e($orderId); ?></span>
                    <p><?php echo e($orderDate); ?></p>
                </div>
            </div>

            
            <div class="section">
                <div class="section-title">👤 Thông tin khách hàng</div>
                <div class="customer-card">
                    <div class="customer-row">
                        <span class="customer-label">Họ tên:</span>
                        <span class="customer-value"><?php echo e($customerName); ?></span>
                    </div>
                    <div class="customer-row">
                        <span class="customer-label">Số điện thoại:</span>
                        <span class="customer-value">
                            <a href="tel:<?php echo e($customerPhone); ?>">
                                <?php echo e($customerPhone); ?>

                            </a>
                        </span>
                    </div>
                    <?php if($customerEmail): ?>
                    <div class="customer-row">
                        <span class="customer-label">Email:</span>
                        <span class="customer-value"><?php echo e($customerEmail); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if($customerZaloId): ?>
                    <div class="customer-row">
                        <span class="customer-label">Zalo:</span>
                        <span class="customer-value"><?php echo e($customerZaloId); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="section">
                <div class="section-title">📦 Sản phẩm đã đặt</div>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>SL</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="item-name">
                                <?php echo e($item['name']); ?>

                                <div class="item-qty">x<?php echo e($item['quantity']); ?></div>
                            </td>
                            <td><?php echo e(number_format($item['price'], 0, ',', '.')); ?>₫</td>
                            <td><?php echo e($item['quantity']); ?></td>
                            <td><?php echo e(number_format($item['subtotal'], 0, ',', '.')); ?>₫</td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            
            <div class="total-section">
                <span class="total-label">💰 TỔNG CỘNG</span>
                <span class="total-value"><?php echo e(number_format($total, 0, ',', '.')); ?>₫</span>
            </div>

            
            <?php if($customerNote): ?>
            <div class="note-section">
                <div class="note-label">📝 Ghi chú từ khách hàng</div>
                <div class="note-content"><?php echo e($customerNote); ?></div>
            </div>
            <?php endif; ?>

            
            <div class="action-section">
                <p>Vui lòng liên hệ khách hàng để xác nhận đơn hàng</p>
                <a href="<?php echo e(url('/admin/inquiries/' . $orderId)); ?>" class="btn">
                    Xem chi tiết đơn hàng
                </a>
            </div>
        </div>

        
        <div class="email-footer">
            <p>Email được gửi tự động từ <strong>Lâm Nhiên Thảo</strong></p>
            <p>
                <a href="<?php echo e(config('app.url', '#')); ?>">Truy cập Admin Panel</a>
            </p>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\Github\FlowerShop\resources\views\emails\admin-order-notification.blade.php ENDPATH**/ ?>