<?php $__env->startSection('page-title', 'Chat với Khách Hàng'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Chat với Khách Hàng</h1>
        <p class="admin-page-subtitle">Quản lý tin nhắn và trò chuyện với khách hàng</p>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body" style="padding: 0;">
        <?php if(isset($users) && $users->count() > 0): ?>
            <div class="chat-users-list">
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('admin.chats.show', $u->id)); ?>" class="chat-user-item">
                        <div class="chat-user-avatar">
                            <?php echo e(strtoupper(mb_substr($u->name ?? 'U', 0, 1, 'UTF-8'))); ?>

                        </div>
                        <div class="chat-user-info">
                            <div class="chat-user-name"><?php echo e($u->name); ?></div>
                            <div class="chat-user-preview">
                                <?php if($u->chatMessages && $u->chatMessages->first()): ?>
                                    <?php if($u->chatMessages->first()->is_admin): ?>
                                        <span class="preview-tag admin">Bạn:</span>
                                    <?php else: ?>
                                        <span class="preview-tag user"><?php echo e($u->name); ?>:</span>
                                    <?php endif; ?>
                                    <?php echo e(\Illuminate\Support\Str::limit($u->chatMessages->first()->message, 60)); ?>

                                <?php else: ?>
                                    <span class="preview-muted">Chưa có tin nhắn</span>
                                <?php endif; ?>
                            </div>
                            <div class="chat-user-meta">
                                <?php if($u->chatMessages && $u->chatMessages->first()): ?>
                                    <span class="chat-user-time"><?php echo e($u->chatMessages->first()->created_at->diffForHumans(null, true, 'vi')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if(isset($u->unread_messages_count) && $u->unread_messages_count > 0): ?>
                            <span class="chat-unread-badge"><?php echo e($u->unread_messages_count); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto var(--space-3); display: block; opacity: 0.4; color: var(--color-text-light);">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <p style="margin: 0; font-size: var(--text-base); color: var(--color-text-light);">Chưa có cuộc trò chuyện nào từ khách hàng.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
<script>
(function() {
    'use strict';

    // Setup Echo for the admin index - subscribe to all active user channels via wildcard
    // Admin can listen on any user's chat channel per channel auth rule
    if (!window.Echo) {
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '<?php echo e(config('broadcasting.connections.pusher.key')); ?>',
            cluster: '<?php echo e(config('broadcasting.connections.pusher.options.cluster')); ?>',
            forceTLS: true,
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }
        });
    }

    // Listen on each user that has a chat-thread (admin can subscribe to any private chat.{id})
    <?php if(isset($users)): ?>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            (function() {
                Echo.private('chat.<?php echo e($u->id); ?>')
                    .listen('MessageSent', function(e) {
                        // Bump unread badge for this user if message is from customer
                        if (e && e.is_admin === false) {
                            var badge = document.querySelector('a[href*="chats/<?php echo e($u->id); ?>"] .chat-unread-badge');
                            if (badge) {
                                var current = parseInt(badge.textContent || '0', 10);
                                badge.textContent = current + 1;
                            } else {
                                var link = document.querySelector('a[href*="chats/<?php echo e($u->id); ?>"]');
                                if (link) {
                                    var newBadge = document.createElement('span');
                                    newBadge.className = 'chat-unread-badge';
                                    newBadge.textContent = '1';
                                    link.appendChild(newBadge);
                                }
                            }
                        }
                    });
            })();
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
})();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Github\FlowerShop\resources\views\admin\chats\index.blade.php ENDPATH**/ ?>