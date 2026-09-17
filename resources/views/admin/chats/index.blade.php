@extends('layouts.admin')

@section('page-title', 'Chat với Khách Hàng')

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-left">
        <h1 class="admin-page-title">Chat với Khách Hàng</h1>
        <p class="admin-page-subtitle">Quản lý tin nhắn và trò chuyện với khách hàng</p>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body" style="padding: 0;">
        @if(isset($users) && $users->count() > 0)
            <div class="chat-users-list">
                @foreach($users as $u)
                    <a href="{{ route('admin.chats.show', $u->id) }}" class="chat-user-item">
                        <div class="chat-user-avatar">
                            {{ strtoupper(mb_substr($u->name ?? 'U', 0, 1, 'UTF-8')) }}
                        </div>
                        <div class="chat-user-info">
                            <div class="chat-user-name">{{ $u->name }}</div>
                            <div class="chat-user-preview">
                                @if($u->chatMessages && $u->chatMessages->first())
                                    @if($u->chatMessages->first()->is_admin)
                                        <span class="preview-tag admin">Bạn:</span>
                                    @else
                                        <span class="preview-tag user">{{ $u->name }}:</span>
                                    @endif
                                    {{ \Illuminate\Support\Str::limit($u->chatMessages->first()->message, 60) }}
                                @else
                                    <span class="preview-muted">Chưa có tin nhắn</span>
                                @endif
                            </div>
                            <div class="chat-user-meta">
                                @if($u->chatMessages && $u->chatMessages->first())
                                    <span class="chat-user-time">{{ $u->chatMessages->first()->created_at->diffForHumans(null, true, 'vi') }}</span>
                                @endif
                            </div>
                        </div>
                        @if(isset($u->unread_messages_count) && $u->unread_messages_count > 0)
                            <span class="chat-unread-badge">{{ $u->unread_messages_count }}</span>
                        @endif
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto var(--space-3); display: block; opacity: 0.4; color: var(--color-text-light);">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <p style="margin: 0; font-size: var(--text-base); color: var(--color-text-light);">Chưa có cuộc trò chuyện nào từ khách hàng.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
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
            key: '{{ config('broadcasting.connections.pusher.key') }}',
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
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
    @if(isset($users))
        @foreach($users as $u)
            (function() {
                Echo.private('chat.{{ $u->id }}')
                    .listen('MessageSent', function(e) {
                        // Bump unread badge for this user if message is from customer
                        if (e && e.is_admin === false) {
                            var badge = document.querySelector('a[href*="chats/{{ $u->id }}"] .chat-unread-badge');
                            if (badge) {
                                var current = parseInt(badge.textContent || '0', 10);
                                badge.textContent = current + 1;
                            } else {
                                var link = document.querySelector('a[href*="chats/{{ $u->id }}"]');
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
        @endforeach
    @endif
})();
</script>
@endpush