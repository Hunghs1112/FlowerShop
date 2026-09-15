<?php $__env->startSection('title', 'Giỏ hàng'); ?>

<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginala9d931d4f11b4d2850df99e991db1dca = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala9d931d4f11b4d2850df99e991db1dca = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-hero','data' => ['title' => 'Giỏ hàng','description' => 'Xem lại các sản phẩm bạn đã chọn trước khi thanh toán','breadcrumbs' => [
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Giỏ hàng']
    ],'image' => $siteBanners['cart'] ?? null,'height' => '350px']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-hero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Giỏ hàng','description' => 'Xem lại các sản phẩm bạn đã chọn trước khi thanh toán','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Trang chủ', 'url' => route('home')],
        ['label' => 'Giỏ hàng']
    ]),'image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($siteBanners['cart'] ?? null),'height' => '350px']); ?>
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

    <?php if($cartItems->count() > 0): ?>
        <div class="checkout-layout">
            <!-- Cart Items -->
            <div class="checkout-main">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Sản phẩm trong giỏ (<?php echo e($cartItems->count()); ?>)</h2>
                    </div>
                    <div class="card-body">
                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="cart-item">
                                <div class="cart-item-image">
                                    <img src="<?php echo e($item->product->getPrimaryImageUrl()); ?>" alt="<?php echo e($item->product->name); ?>">
                                </div>
                                <div class="cart-item-info">
                                    <h3 class="cart-item-name">
                                        <a href="<?php echo e(route('products.show', $item->product->display_slug)); ?>">
                                            <?php echo e($item->product->name); ?>

                                        </a>
                                    </h3>
                                    <?php if($item->product->category): ?>
                                        <p class="cart-item-category"><?php echo e($item->product->category->name); ?></p>
                                    <?php endif; ?>
                                    <?php if($item->product->stock <= 0): ?>
                                        <span class="badge badge-danger">Hết hàng</span>
                                    <?php elseif($item->product->stock < $item->quantity): ?>
                                        <span class="badge badge-warning">Chỉ còn <?php echo e($item->product->stock); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="cart-item-price">
                                    <?php echo e(number_format($item->product->price, 0, ',', '.')); ?>₫
                                </div>
                                <div class="cart-item-quantity">
                                    <form action="<?php echo e(route('cart.update', $item->id)); ?>" method="POST" class="quantity-form">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <div class="quantity-selector">
                                            <button type="button" class="qty-btn" onclick="updateCartQty(this, -1)">-</button>
                                            <input type="number" name="quantity" value="<?php echo e($item->quantity); ?>" 
                                                   min="1" max="<?php echo e($item->product->stock); ?>" 
                                                   class="qty-input" onchange="this.form.submit()">
                                            <button type="button" class="qty-btn" onclick="updateCartQty(this, 1)">+</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="cart-item-total">
                                    <?php echo e(number_format($item->getSubtotal(), 0, ',', '.')); ?>₫
                                </div>
                                <div class="cart-item-actions">
                                    <form action="<?php echo e(route('cart.destroy', $item->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn-icon" title="Xóa" aria-label="Xóa">
                                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="cart-actions">
                    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Tiếp tục mua sắm
                    </a>
                    <form action="<?php echo e(route('cart.clear')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-secondary" onclick="return confirm('Xóa tất cả sản phẩm khỏi giỏ hàng?')">
                            Xóa giỏ hàng
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="checkout-sidebar">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Tổng cộng</h2>
                    </div>
                    <div class="card-body">
                        <div class="summary-row">
                            <span>Tạm tính (<?php echo e($cartItems->count()); ?> sản phẩm)</span>
                            <span class="summary-value"><?php echo e(number_format($total, 0, ',', '.')); ?>₫</span>
                        </div>
                        <div class="summary-row summary-total">
                            <span>Tổng cộng</span>
                            <span class="summary-value"><?php echo e(number_format($total, 0, ',', '.')); ?>₫</span>
                        </div>
                        <a href="<?php echo e(route('checkout.index')); ?>" class="btn btn-primary btn-lg btn-block">
                            Thanh toán
                        </a>
                        <p class="checkout-note">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Chúng tôi sẽ liên hệ xác nhận đơn hàng sau khi bạn đặt.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="empty-cart">
            <svg width="120" height="120" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h2>Giỏ hàng trống</h2>
            <p>Hãy chọn những sản phẩm yêu thích của bạn!</p>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary btn-lg">
                Xem sản phẩm
            </a>
        </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function updateCartQty(btn, delta) {
        const form = btn.closest('.quantity-form');
        const input = form.querySelector('input[name="quantity"]');
        const current = parseInt(input.value) || 1;
        const max = parseInt(input.max);
        const newVal = current + delta;
        
        if (newVal >= 1 && newVal <= max) {
            input.value = newVal;
            form.submit();
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\hungh\OneDrive\Documents\GitHub\FlowerShop\resources\views/cart/index.blade.php ENDPATH**/ ?>