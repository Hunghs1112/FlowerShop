<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $siteSettings['site_name'] ?? config('app.name')) - {{ $siteSettings['site_name'] ?? config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}?v=4">
    <link rel="stylesheet" href="{{ asset('css/chat-button.css') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/font-unification.css') }}">
</head>
<body class="@yield('body-class')">
    @if(!View::hasSection('skip-navbar'))
        @include('partials.navbar')
    @endif

    @if(!View::hasSection('skip-main-wrapper'))
    <main class="main-content">
        @yield('content')
    </main>
    @else
        @yield('content')
    @endif

    @if(!View::hasSection('skip-footer'))
        @include('partials.footer')
    @endif

    {{-- Floating chat widget (visible to all non-admin users including guests) --}}
    @if(!auth()->check() || !auth()->user()->is_admin)
        <div class="floating-chat-container">
                {{-- Chat window --}}
                <div class="floating-chat-window" id="floatingChatWindow">
                    {{-- Header --}}
                    <div class="floating-chat-header">
                        <div class="floating-chat-header-avatar">A</div>
                        <div class="floating-chat-header-info">
                            <h3 class="floating-chat-header-title">Hỗ trợ khách hàng</h3>
                            <div class="floating-chat-header-status">Trực tuyến</div>
                        </div>
                    </div>

                    {{-- Messages --}}
                    <div class="floating-chat-messages" id="floatingChatMessages">
                        <div class="floating-chat-empty">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <p>Chưa có tin nhắn nào.<br>Hãy gửi tin nhắn để bắt đầu trò chuyện!</p>
                        </div>
                    </div>

                    {{-- Input form --}}
                    <form class="floating-chat-input" id="floatingChatForm">
                        <textarea 
                            id="floatingChatInput" 
                            placeholder="Nhập tin nhắn..."
                            rows="1"
                        ></textarea>
                        <button type="submit" id="floatingChatSend">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <div class="floating-contact-links" aria-label="Liên hệ nhanh">
                    @if(!empty($siteSettings['zalo_url']))
                    <a class="floating-contact-btn floating-contact-btn--zalo" href="{{ $siteSettings['zalo_url'] }}" target="_blank" rel="noopener noreferrer" aria-label="Liên hệ qua Zalo" data-label="Zalo"><span aria-hidden="true">Zalo</span></a>
                    @endif
                    @if(!empty($siteSettings['facebook_url']))
                    <a class="floating-contact-btn floating-contact-btn--facebook" href="{{ $siteSettings['facebook_url'] }}" target="_blank" rel="noopener noreferrer" aria-label="Liên hệ qua Facebook" data-label="Facebook">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M13.4 21v-8.2h2.8l.4-3.2h-3.2V7.5c0-.9.3-1.5 1.6-1.5h1.7V3.1c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3v2.3H7.2v3.2H10V21h3.4Z"/></svg>
                    </a>
                    @endif
                    @if(!empty($siteSettings['phone']))
                    <a class="floating-contact-btn floating-contact-btn--phone" href="tel:{{ preg_replace('/\D/', '', $siteSettings['phone']) }}" aria-label="Gọi {{ $siteSettings['phone'] }}" data-label="{{ $siteSettings['phone'] }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5.5A1.5 1.5 0 0 1 5.5 4h2a1.5 1.5 0 0 1 1.46 1.15l.55 2.36a1.5 1.5 0 0 1-.67 1.62l-1.2.8a12 12 0 0 0 6.43 6.43l.8-1.2a1.5 1.5 0 0 1 1.62-.67l2.36.55A1.5 1.5 0 0 1 20 16.5v2A1.5 1.5 0 0 1 18.5 20 14.5 14.5 0 0 1 4 5.5Z"/></svg>
                    </a>
                    @endif
                </div>

                {{-- Toggle button --}}
                <button class="floating-chat-btn" id="floatingChatBtn" aria-label="Chat hỗ trợ">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span class="floating-chat-badge" id="chatUnreadBadge" style="display: none;">0</span>
                </button>
            </div>
        @endif

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
                    showNotification('Đã thêm vào giỏ hàng!', 'success');
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

        // Wishlist toggle handler - Global
        document.addEventListener('click', function(e) {
            const wishlistBtn = e.target.closest('.product-card__wishlist');
            if (!wishlistBtn) return;

            e.preventDefault();
            e.stopPropagation();

            @guest
                showNotification('Vui lòng đăng nhập để sử dụng tính năng này', 'info');
                setTimeout(() => {
                    window.location.href = '{{ route("login") }}';
                }, 1500);
                return;
            @endguest

            const productId = wishlistBtn.dataset.productId;
            const isActive = wishlistBtn.classList.contains('active');

            // Optimistic UI update
            wishlistBtn.classList.toggle('active');
            const svg = wishlistBtn.querySelector('svg');
            svg.setAttribute('fill', wishlistBtn.classList.contains('active') ? 'currentColor' : 'none');

            // Send request
            fetch('{{ route("favorites.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    // Revert on failure
                    wishlistBtn.classList.toggle('active');
                    svg.setAttribute('fill', wishlistBtn.classList.contains('active') ? 'currentColor' : 'none');
                } else {
                    showNotification(data.message, 'success');
                    
                    // If removed and we're on favorites page, remove the card
                    if (isActive && window.location.pathname === '/yeu-thich') {
                        const card = wishlistBtn.closest('.product-card');
                        if (card) {
                            card.style.opacity = '0';
                            card.style.transform = 'scale(0.95)';
                            card.style.transition = 'opacity 0.3s, transform 0.3s';
                            setTimeout(() => {
                                card.remove();
                                // Reload if no products left
                                if (document.querySelectorAll('.product-card').length === 0) {
                                    window.location.reload();
                                }
                            }, 300);
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert on error
                wishlistBtn.classList.toggle('active');
                svg.setAttribute('fill', wishlistBtn.classList.contains('active') ? 'currentColor' : 'none');
                showNotification('Có lỗi xảy ra, vui lòng thử lại', 'error');
            });
        });
    </script>

    {{-- Floating chat widget logic (visible to all non-admin users including guests) --}}
    @if(!auth()->check() || !auth()->user()->is_admin)
        <script>
        (function() {
            const btn = document.getElementById('floatingChatBtn');
            const badge = document.getElementById('chatUnreadBadge');
            const chatWindow = document.getElementById('floatingChatWindow');
            const messagesDiv = document.getElementById('floatingChatMessages');
            const form = document.getElementById('floatingChatForm');
            const input = document.getElementById('floatingChatInput');
            const sendBtn = document.getElementById('floatingChatSend');
            const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
            const userInitial = '{{ auth()->check() ? strtoupper(mb_substr(auth()->user()->name, 0, 1, "UTF-8")) : "G" }}';
            
            if (!btn || !chatWindow) return;

            let isOpen = false;
            let lastMessageId = 0;

            // Toggle chat window
            btn.addEventListener('click', function() {
                isOpen = !isOpen;
                chatWindow.classList.toggle('open', isOpen);
                if (isOpen) {
                    loadMessages();
                    input.focus();
                }
            });

            // Close when clicking outside
            document.addEventListener('click', function(e) {
                if (isOpen && !chatWindow.contains(e.target) && !btn.contains(e.target)) {
                    isOpen = false;
                    chatWindow.classList.remove('open');
                }
            });

            // Auto-grow textarea
            input.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 80) + 'px';
            });

            // Load messages
            function loadMessages() {
                fetch('{{ route("chat.messages") }}', {
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.messages && data.messages.length > 0) {
                        const empty = messagesDiv.querySelector('.floating-chat-empty');
                        if (empty) empty.remove();
                        
                        data.messages.forEach(msg => {
                            appendMessage(msg.message, msg.is_admin, msg.created_at, msg.id);
                            if (msg.id > lastMessageId) lastMessageId = msg.id;
                        });
                        scrollToBottom();
                    }
                })
                .catch(err => console.error('[Chat] Load error:', err));
            }

            // Append message
            function appendMessage(text, isAdmin, time, msgId) {
                if (msgId && document.getElementById('fmsg-' + msgId)) return;

                const empty = messagesDiv.querySelector('.floating-chat-empty');
                if (empty) empty.remove();

                const wrapper = document.createElement('div');
                wrapper.className = 'floating-chat-message ' + (isAdmin ? 'admin' : 'user');
                if (msgId) wrapper.id = 'fmsg-' + msgId;

                const avatar = document.createElement('div');
                avatar.className = 'floating-chat-message-avatar';
                avatar.textContent = isAdmin ? 'A' : userInitial;

                const bubble = document.createElement('div');
                bubble.className = 'floating-chat-message-bubble';
                bubble.textContent = text;

                wrapper.appendChild(avatar);
                wrapper.appendChild(bubble);
                messagesDiv.appendChild(wrapper);
                scrollToBottom();
            }

            // Send message
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const message = input.value.trim();
                if (!message) return;
                
                // Guest users need to login first
                if (!isLoggedIn) {
                    alert('Vui lòng đăng nhập để gửi tin nhắn hỗ trợ');
                    window.location.href = '{{ route("login") }}?redirect=' + encodeURIComponent(window.location.pathname);
                    return;
                }

                sendBtn.disabled = true;
                const originalHTML = sendBtn.innerHTML;
                sendBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity="0.25"/></svg>';

                try {
                    const response = await fetch('{{ route("chat.send") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ message: message })
                    });

                    const data = await response.json();
                    if (data.success && data.message) {
                        appendMessage(data.message.message, false, data.message.created_at, data.message.id);
                        if (data.message.id > lastMessageId) lastMessageId = data.message.id;
                        input.value = '';
                        input.style.height = 'auto';
                    }
                } catch (err) {
                    console.error('[Chat] Send error:', err);
                } finally {
                    sendBtn.disabled = false;
                    sendBtn.innerHTML = originalHTML;
                    input.focus();
                }
            });

            // Polling for new messages
            setInterval(function() {
                if (!isOpen) return;
                
                fetch('{{ route("chat.poll") }}?after=' + lastMessageId, {
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.messages && data.messages.length > 0) {
                        data.messages.forEach(msg => {
                            appendMessage(msg.message, msg.is_admin, msg.created_at, msg.id);
                            if (msg.id > lastMessageId) lastMessageId = msg.id;
                        });
                    }
                })
                .catch(err => console.error('[Chat] Poll error:', err));
            }, 3000);

            // Unread count
            function updateUnreadCount() {
                fetch('{{ route("chat.unread-count") }}', {
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                })
                .then(r => r.json())
                .then(data => {
                    const count = data.count || 0;
                    if (count > 0) {
                        badge.textContent = count > 99 ? '99+' : count;
                        badge.style.display = 'flex';
                        btn.classList.add('has-unread');
                    } else {
                        badge.style.display = 'none';
                        btn.classList.remove('has-unread');
                    }
                })
                .catch(err => console.error('[Chat] Unread error:', err));
            }

            updateUnreadCount();
            setInterval(updateUnreadCount, 10000);

            function scrollToBottom() {
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            }
        })();
        </script>
        @endif

    @stack('scripts')
</body>
</html>
