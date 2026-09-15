<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $siteSettings['site_name'] ?? config('app.name')) - {{ $siteSettings['site_name'] ?? config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @php
        // Cache busting: append file modification time as query string
        function cssv(string $path): string {
            $full = public_path($path);
            $v = file_exists($full) ? filemtime($full) : time();
            return asset($path) . '?v=' . $v;
        }
    @endphp
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ cssv('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/theme.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/layout-fixes.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/navbar-dropdown.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/footer.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/home.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/hero.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/page-hero.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/products-section.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/products/card.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/categories-section.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/brand-values-section.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/partners-section.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/inspiration-section.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/instagram-section.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/products.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/products/filter.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/products/toolbar.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/products/hero.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/products/pagination.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/products/grid.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/product-detail.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/blog.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/auth.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/account.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/pages.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/cart.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/checkout.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/categories.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/zalo-info.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/components.css') }}">
    <link rel="stylesheet" href="{{ cssv('css/components/notification.css') }}">
    
    @stack('styles')
</head>
<body>
    @include('partials.navbar')

    <main class="main-content">
        @yield('content')
    </main>

    @include('partials.footer')

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
                    showNotification('{{ __('messages.products.add_to_cart_success') }}', 'success');
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
    
    @stack('scripts')
</body>
</html>
