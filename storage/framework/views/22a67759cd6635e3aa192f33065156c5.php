<!-- 
    FlowerShop Swoole WebSocket Integration
    Add this to your chat views to enable real-time messaging
-->

<script src="<?php echo e(asset('js/swoole-websocket.js')); ?>"></script>

<script>
    // Initialize Swoole WebSocket connection
    const swoole = new SwooleWebSocket({
        host: window.location.hostname,
        port: <?php echo e(env('SWOOLE_PORT', 9501)); ?>,
        secure: window.location.protocol === 'https:',
        debug: <?php echo e(config('app.debug') ? 'true' : 'false'); ?>,
        reconnectInterval: 3000,
        maxReconnectAttempts: 10,
    });

    // Connection status indicator
    const connectionStatus = document.getElementById('connection-status');
    
    swoole.on('connect', () => {
        console.log('✅ Connected to real-time server');
        if (connectionStatus) {
            connectionStatus.classList.add('connected');
            connectionStatus.classList.remove('disconnected');
            connectionStatus.textContent = 'Connected';
        }
    });

    swoole.on('disconnect', () => {
        console.log('❌ Disconnected from real-time server');
        if (connectionStatus) {
            connectionStatus.classList.remove('connected');
            connectionStatus.classList.add('disconnected');
            connectionStatus.textContent = 'Disconnected';
        }
    });

    swoole.on('error', (error) => {
        console.error('WebSocket error:', error);
    });

    // Connect to server
    swoole.connect().catch(error => {
        console.error('Failed to connect:', error);
        alert('Không thể kết nối đến server real-time. Vui lòng refresh trang.');
    });

    // Example: Subscribe to chat channel
    <?php if(isset($chatId)): ?>
    swoole.channel('chat.<?php echo e($chatId); ?>')
        .listen('MessageSent', (data) => {
            console.log('New message received:', data);
            
            // Add message to chat UI
            if (typeof appendMessage === 'function') {
                appendMessage(data.message);
            }
            
            // Play notification sound
            if (typeof playNotificationSound === 'function') {
                playNotificationSound();
            }
            
            // Update unread count
            if (typeof updateUnreadCount === 'function') {
                updateUnreadCount();
            }
        });
    <?php endif; ?>

    // Example: Subscribe to admin notifications
    <?php if(auth()->guard()->check()): ?>
    <?php if(auth()->user()->isAdmin()): ?>
    swoole.channel('admin.notifications')
        .listen('NewOrder', (data) => {
            console.log('New order:', data);
            showNotification('New Order', data.message);
        })
        .listen('NewMessage', (data) => {
            console.log('New message:', data);
            updateAdminBadge();
        });
    <?php endif; ?>
    <?php endif; ?>

    // Heartbeat ping every 30 seconds
    setInterval(() => {
        if (swoole.connected) {
            swoole.ping();
        }
    }, 30000);

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        swoole.disconnect();
    });

    // Helper: Show browser notification
    function showNotification(title, message) {
        if ('Notification' in window && Notification.permission === 'granted') {
            new Notification(title, {
                body: message,
                icon: '/images/logo.png',
                badge: '/images/badge.png',
            });
        }
    }

    // Helper: Play notification sound
    function playNotificationSound() {
        const audio = new Audio('/sounds/notification.mp3');
        audio.volume = 0.5;
        audio.play().catch(e => console.log('Cannot play sound:', e));
    }
</script>

<!-- Connection status indicator (optional UI) -->
<style>
    #connection-status {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        z-index: 9999;
        transition: all 0.3s ease;
        background: #94a3b8;
        color: white;
    }
    
    #connection-status.connected {
        background: #22c55e;
    }
    
    #connection-status.disconnected {
        background: #ef4444;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>

<div id="connection-status" style="display: none;">
    Connecting...
</div>

<script>
    // Show connection status on page load
    setTimeout(() => {
        const status = document.getElementById('connection-status');
        if (status) status.style.display = 'block';
    }, 1000);
</script>
<?php /**PATH D:\Github\FlowerShop\resources\views\partials\swoole-websocket.blade.php ENDPATH**/ ?>