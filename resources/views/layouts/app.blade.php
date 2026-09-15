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

    {{-- Tailwind CDN (for development / preview) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Compiled CSS (auto-detect from manifest.json) --}}
    @if(isset($viteCss))
    <link rel="stylesheet" href="{{ asset($viteCss) }}">
    @endif

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
