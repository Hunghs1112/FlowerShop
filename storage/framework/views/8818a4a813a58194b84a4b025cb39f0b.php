<?php $__env->startSection('title', 'Đặt hàng thành công'); ?>

<?php $__env->startSection('content'); ?>
<div class="checkout-page success-page">
    <div class="container">
        <div class="success-container">
            <div class="success-icon">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <h1 class="success-title">Đặt hàng thành công!</h1>
            <p class="success-message">Cảm ơn bạn đã tin tưởng và lựa chọn LNT Flower. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất để xác nhận đơn hàng.</p>

            <?php if($inquiry ?? null): ?>
            <div class="success-order-info">
                <div class="order-info-item">
                    <span class="order-info-label">Mã đơn hàng</span>
                    <span class="order-info-value">#<?php echo e($inquiry->id); ?></span>
                </div>
                <div class="order-info-divider"></div>
                <div class="order-info-item">
                    <span class="order-info-label">Ngày đặt</span>
                    <span class="order-info-value"><?php echo e($inquiry->created_at->format('d/m/Y')); ?></span>
                </div>
            </div>
            <?php endif; ?>

            <div class="success-details">
                <div class="detail-card">
                    <div class="detail-card-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3>Tiếp theo là gì?</h3>
                        <p>Chúng tôi sẽ liên hệ xác nhận đơn hàng qua Zalo hoặc điện thoại trong thời gian sớm nhất.</p>
                    </div>
                </div>

                <div class="detail-card">
                    <div class="detail-card-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                        </svg>
                    </div>
                    <div>
                        <h3>Theo dõi đơn hàng</h3>
                        <p>Nhắn tin cho chúng tôi bất cứ lúc nào qua chat để được tư vấn và cập nhật đơn hàng.</p>
                    </div>
                </div>
            </div>

            <div class="success-actions">
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary btn-lg">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Tiếp tục mua sắm
                </a>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('profile.show')); ?>" class="btn btn-outline btn-lg">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Xem tài khoản
                    </a>
                <?php endif; ?>
            </div>

            <div class="success-flower-decoration">
                <svg viewBox="0 0 200 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 50C20 50 25 30 40 30C55 30 60 50 60 50" stroke="#A3B8A1" stroke-width="1.5" stroke-linecap="round"/>
                    <circle cx="40" cy="25" r="8" fill="#E8B4B8" opacity="0.6"/>
                    <circle cx="40" cy="25" r="5" fill="#D4969A"/>
                    <path d="M140 50C140 50 145 30 160 30C175 30 180 50 180 50" stroke="#A3B8A1" stroke-width="1.5" stroke-linecap="round"/>
                    <circle cx="160" cy="25" r="8" fill="#E8B4B8" opacity="0.6"/>
                    <circle cx="160" cy="25" r="5" fill="#D4969A"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<style>
.success-order-info {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-5);
    padding: var(--space-5) var(--space-6);
    background: var(--color-white);
    border: 1px solid var(--color-border-light);
    border-radius: var(--radius-lg);
    margin-bottom: var(--space-6);
}

.order-info-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--space-1);
}

.order-info-label {
    font-size: 0.8125rem;
    color: var(--color-text-light);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.order-info-value {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--color-primary);
}

.order-info-divider {
    width: 1px;
    height: 32px;
    background: var(--color-border);
}

.detail-card-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--color-botanical-pale);
    color: var(--color-primary);
    border-radius: var(--radius-full);
    flex-shrink: 0;
}

.detail-card-icon svg {
    width: 20px;
    height: 20px;
}

.success-flower-decoration {
    margin-top: var(--space-8);
    opacity: 0.6;
}

.success-flower-decoration svg {
    width: 200px;
    height: 60px;
}

@media (max-width: 640px) {
    .success-order-info {
        flex-direction: column;
        gap: var(--space-3);
    }

    .order-info-divider {
        width: 60px;
        height: 1px;
    }
}
</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /root/FlowerShop/resources/views/checkout/success.blade.php ENDPATH**/ ?>