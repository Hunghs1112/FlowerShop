<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', $siteSettings['site_name'] ?? config('app.name')); ?> - <?php echo e($siteSettings['site_name'] ?? config('app.name')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <?php
        // Cache busting: append file modification time as query string
        function cssv(string $path): string {
            $full = public_path($path);
            $v = file_exists($full) ? filemtime($full) : time();
            return asset($path) . '?v=' . $v;
        }
    ?>
    
    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo e(cssv('css/fonts.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/theme.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/layout-fixes.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/navbar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/navbar-dropdown.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/footer.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/home.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/hero.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/page-hero.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/products-section.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/products/card.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/categories-section.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/brand-values-section.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/partners-section.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/inspiration-section.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/instagram-section.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/products.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/products/filter.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/products/toolbar.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/products/hero.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/products/pagination.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/products/grid.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/product-detail.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/blog.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/auth.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/account.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/pages.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/cart.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/checkout.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/categories.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/zalo-info.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/components.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(cssv('css/components/notification.css')); ?>">
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="main-content">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Scripts -->
    <script>
        // Cart count update helper
        function updateCartCount(count) {
            const cartBadge = document.querySelector('.cart-badge');
            if (cartBadge) {
                cartBadge.textContent = count;
                cartBadge.style.display = count > 0 ? 'flex' : 'none';
            }
        }

        // Favorite toggle helper — removed

        // Add to cart helper
        function addToCart(productId, quantity = 1) {
            fetch('/gio-hang/them', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartCount(data.cart_count);
                    showNotification('<?php echo e(__('messages.products.add_to_cart_success')); ?>', 'success');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Simple notification helper
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.textContent = message;
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.style.animation = 'notification-out 0.3s ease-out forwards';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\hungh\OneDrive\Documents\GitHub\FlowerShop\resources\views/layouts/app.blade.php ENDPATH**/ ?>