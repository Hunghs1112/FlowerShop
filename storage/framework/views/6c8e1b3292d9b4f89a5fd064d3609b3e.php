

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng #<?php echo e($orderId); ?></title>
</head>
<body>
    <div class="email-wrapper">
        
        <div class="email-header">
            <h1>🌸 Lâm Nhiên Thảo</h1>
            <p>Xác nhận đơn hàng thành công</p>
        </div>

        
        <div class="email-body">
            
            <div class="greeting">
                Xin chào <strong><?php echo e($customerName); ?></strong>!
            </div>

            
            <p>
                Cảm ơn bạn đã đặt hàng tại <strong>Lâm Nhiên Thảo</strong>. 
                Chúng tôi đã tiếp nhận đơn hàng của bạn và sẽ liên hệ trong thời gian sớm nhất để xác nhận.
            </p>

            
            <div class="order-info">
                <h3>📋 Thông tin đơn hàng #<?php echo e($orderId); ?></h3>
                <div class="info-row">
                    <span class="info-label">Ngày đặt:</span>
                    <span class="info-value"><?php echo e($orderDate); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Số điện thoại:</span>
                    <span class="info-value"><?php echo e($customerPhone); ?></span>
                </div>
                <?php if($customerEmail): ?>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?php echo e($customerEmail); ?></span>
                </div>
                <?php endif; ?>
            </div>

            
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
                        <td>
                            <?php echo e($item['name']); ?>

                            <div class="item-qty">x<?php echo e($item['quantity']); ?></div>
                        </td>
                        <td><?php echo e(number_format($item['price'], 0, ',', '.')); ?>₫</td>
                        <td><?php echo e($item['quantity']); ?></td>
                        <td><?php echo e(number_format($item['subtotal'], 0, ',', '.')); ?>₫</td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr class="total-row">
                        <td colspan="3"><strong>TỔNG CỘNG</strong></td>
                        <td><strong><?php echo e(number_format($total, 0, ',', '.')); ?>₫</strong></td>
                    </tr>
                </tbody>
            </table>

            
            <?php if($customerNote): ?>
            <div class="note-section">
                <h4>📝 Ghi chú của bạn:</h4>
                <p><?php echo e($customerNote); ?></p>
            </div>
            <?php endif; ?>

            
            <div class="contact-section">
                <h3>Bước tiếp theo</h3>
                <p>📞 Chúng tôi sẽ gọi điện xác nhận đơn hàng trong vài phút tới</p>
                <p>💬 Nếu có thắc mắc, vui lòng liên hệ hotline hoặc Zalo</p>
            </div>
        </div>

        
        <div class="email-footer">
            <p><strong>Lâm Nhiên Thảo</strong> - Flowers & Gifts</p>
            <p>Địa chỉ: <?php echo e(config('app.address', 'TP. Hồ Chí Minh')); ?></p>
            <div class="social-links">
                <a href="<?php echo e(config('services.zalo.hotline', '#')); ?>">Zalo</a> | 
                <a href="<?php echo e(config('app.url', '#')); ?>">Website</a>
            </div>
            <p>
                Email này được gửi tự động. Vui lòng không reply email này.
            </p>
        </div>
    </div>
</body>
</html>
<?php /**PATH /root/FlowerShop/resources/views/emails/order-confirmation.blade.php ENDPATH**/ ?>