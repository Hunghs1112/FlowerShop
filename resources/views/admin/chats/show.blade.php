@extends('layouts.admin')

@section('page-title', 'Chat - ' . $user->name)

@section('content')
<div class="admin-chat-layout">
    {{-- Sidebar: Users list --}}
    <aside class="admin-chat-sidebar">
        <div class="chat-sidebar-header">
            <h3 class="chat-sidebar-title">Tin nhắn</h3>
            <span class="chat-sidebar-count">{{ isset($users) ? $users->count() : 0 }}</span>
        </div>
        <div class="chat-users-list">
            @if(isset($users))
                @foreach($users as $u)
                    <a href="{{ route('admin.chats.show', $u->id) }}"
                       class="chat-user-item {{ isset($user) && $u->id == $user->id ? 'active' : '' }}">
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
                                    {{ \Illuminate\Support\Str::limit($u->chatMessages->first()->message, 40) }}
                                @else
                                    <span class="preview-muted">Chưa có tin nhắn</span>
                                @endif
                            </div>
                        </div>
                        @if(isset($u->unread_messages_count) && $u->unread_messages_count > 0)
                            <span class="chat-unread-badge">{{ $u->unread_messages_count }}</span>
                        @endif
                    </a>
                @endforeach
            @endif
        </div>
    </aside>

    {{-- Main: Chat panel --}}
    <main class="admin-chat-main">
        {{-- Header --}}
        <header class="admin-chat-header">
            <button type="button" class="admin-chat-back-btn" id="backToList" aria-label="Quay lại">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <div class="chat-header-user">
                <div class="chat-user-avatar-lg">
                    {{ strtoupper(mb_substr($user->name ?? 'U', 0, 1, 'UTF-8')) }}
                </div>
                <div class="chat-header-user-info">
                    <h2 class="chat-header-user-name">{{ $user->name }}</h2>
                    <p class="chat-header-user-email">{{ $user->email }}</p>
                </div>
            </div>
            <span class="chat-status" id="connectionStatus">
                <span class="status-dot"></span>
                <span class="status-text">Đang kết nối...</span>
            </span>
        </header>

        {{-- Messages --}}
        <div class="chat-messages" id="chatMessages">
            @forelse($messages as $message)
                <div class="chat-message {{ $message->is_admin ? 'admin' : 'user' }}" id="msg-{{ $message->id }}">
                    @if(!$message->is_admin)
                        <div class="chat-message-avatar">
                            {{ strtoupper(mb_substr($message->user->name ?? 'U', 0, 1, 'UTF-8')) }}
                        </div>
                    @endif
                    <div class="message-bubble">
                        <div class="message-text">{{ $message->message }}</div>
                        <div class="message-time">{{ $message->created_at->format('H:i') }}</div>
                    </div>
                </div>
            @empty
                <div class="chat-empty" id="emptyState">
                    <div class="chat-empty-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <h3 class="chat-empty-title">Chưa có tin nhắn</h3>
                    <p class="chat-empty-text">Hãy bắt đầu cuộc trò chuyện với {{ $user->name }}.</p>
                </div>
            @endforelse
        </div>

        {{-- Reply form --}}
        <form class="chat-input-form" id="chatForm" autocomplete="off">
            @csrf
            <input type="hidden" id="userId" value="{{ $user->id }}">
            <input
                type="text"
                id="messageInput"
                class="chat-input"
                placeholder="Nhập tin nhắn..."
                maxlength="1000"
                autocomplete="off"
                required
            >
            <button type="submit" class="chat-send-btn" id="sendBtn" aria-label="Gửi tin nhắn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </button>
        </form>
    </main>
</div>
@endsection

@push('scripts')
{{-- Load Laravel Echo từ CDN - Reverb dùng native WebSocket (không cần Pusher JS) --}}
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
<script>
(function() {
    'use strict';

    // === Laravel Echo setup với Reverb (VPS) ===
    // Local dev: không có Reverb → chỉ dùng polling, skip Echo
    const reverbKey = '{{ config('broadcasting.connections.reverb.key') }}';
    const reverbHost = '{{ config('broadcasting.connections.reverb.host') }}';
    const reverbPort = {{ config('broadcasting.connections.reverb.port') ?? 'null' }};
    
    if (reverbKey && reverbHost && reverbPort) {
        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: reverbKey,
            wsHost: reverbHost,
            wsPort: reverbPort,
            wssPort: reverbPort,
            forceTLS: {{ config('broadcasting.connections.reverb.scheme') === 'https' ? 'true' : 'false' }},
            enabledTransports: ['ws', 'wss'],
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }
        });
    }

    const currentUserId = {{ $user->id }};
    const messagesDiv = document.getElementById('chatMessages');
    const form = document.getElementById('chatForm');
    const input = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');
    const connectionStatus = document.getElementById('connectionStatus');
    const backToListBtn = document.getElementById('backToList');
    const emptyState = document.getElementById('emptyState');

    // === Auto-scroll to bottom on load ===
    function scrollToBottom() {
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }
    scrollToBottom();

    // === Connection status ===
    function setStatus(state) {
        if (!connectionStatus) return;
        connectionStatus.classList.remove('connected', 'disconnected');
        if (state === 'connected') {
            connectionStatus.classList.add('connected');
            connectionStatus.querySelector('.status-text').textContent = 'Đã kết nối';
        } else if (state === 'disconnected') {
            connectionStatus.classList.add('disconnected');
            connectionStatus.querySelector('.status-text').textContent = 'Mất kết nối';
        } else {
            connectionStatus.querySelector('.status-text').textContent = 'Đang kết nối...';
        }
    }

    // === Escape HTML to prevent XSS ===
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // === Format time ===
    function formatTime(time) {
        if (!time) return 'Vừa xong';
        if (typeof time === 'string' && time.match(/^\d{1,2}:\d{2}$/)) return time;
        try {
            const d = new Date(time);
            if (isNaN(d.getTime())) return time;
            const hh = String(d.getHours()).padStart(2, '0');
            const mm = String(d.getMinutes()).padStart(2, '0');
            return hh + ':' + mm;
        } catch (e) {
            return time;
        }
    }

    // === Append message ===
    function appendMessage(text, isAdmin, sender, time, messageId) {
        // Check duplicate first
        if (messageId && document.getElementById('msg-' + messageId)) {
            return; // Already exists
        }

        if (emptyState && emptyState.parentNode) {
            emptyState.remove();
        }

        const wrapper = document.createElement('div');
        wrapper.className = 'chat-message ' + (isAdmin ? 'admin' : 'user');
        if (messageId) wrapper.id = 'msg-' + messageId;

        if (!isAdmin) {
            const avatar = document.createElement('div');
            avatar.className = 'chat-message-avatar';
            avatar.textContent = '{{ strtoupper(mb_substr($user->name ?? "U", 0, 1, "UTF-8")) }}';
            wrapper.appendChild(avatar);
        }

        const bubble = document.createElement('div');
        bubble.className = 'message-bubble';
        bubble.innerHTML =
            '<div class="message-text">' + escapeHtml(text) + '</div>' +
            '<div class="message-time">' + escapeHtml(formatTime(time)) + '</div>';
        wrapper.appendChild(bubble);

        messagesDiv.appendChild(wrapper);
        scrollToBottom();
    }

    // === Subscribe to private channel of this user ===
    if (window.Echo && typeof window.Echo.private === 'function') {
        window.Echo.private('chat.' + currentUserId)
            .listen('MessageSent', function(e) {
                if (!e) return;
                if (e.id && document.getElementById('msg-' + e.id)) {
                    return; // already exists
                }
                appendMessage(e.message, e.is_admin, e.sender_name, e.created_at, e.id);
            })
            .subscribed(function() {
                setStatus('connected');
            });

        // Reverb connection events (native WS, không qua Pusher)
        if (window.Echo.connector && window.Echo.connector.connector) {
            window.Echo.connector.connector.on('connect', function() { setStatus('connected'); });
            window.Echo.connector.connector.on('disconnect', function() { setStatus('disconnected'); });
            window.Echo.connector.connector.on('connect_error', function() { setStatus('disconnected'); });
        }
    } else {
        // Local dev: không có WebSocket → hiển thị polling mode
        setStatus('connected');
        connectionStatus.querySelector('.status-text').textContent = 'Polling mode';
        
        // Polling cho admin: check tin nhắn mới từ user mỗi 3 giây
        let lastMessageId = 0;
        const allMessages = messagesDiv.querySelectorAll('.chat-message[id^="msg-"]');
        if (allMessages.length > 0) {
            const lastMsg = allMessages[allMessages.length - 1];
            const msgId = lastMsg.id.replace('msg-', '');
            lastMessageId = parseInt(msgId) || 0;
        }
        
        setInterval(async function() {
            try {
                const response = await fetch('{{ route("admin.chats.poll") }}?user_id=' + currentUserId + '&after=' + lastMessageId, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.messages && data.messages.length > 0) {
                    data.messages.forEach(function(msg) {
                        appendMessage(msg.message, msg.is_admin, msg.sender_name, msg.created_at, msg.id);
                        lastMessageId = Math.max(lastMessageId, msg.id);
                    });
                }
            } catch (err) {
                console.error('[Admin Chat Poll] Error:', err);
            }
        }, 3000);
    }

    // === Send message ===
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;

        sendBtn.disabled = true;
        const originalContent = sendBtn.innerHTML;
        sendBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="spinner"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"/><path d="M12 2a10 10 0 0110 10"/></svg>';

        try {
            const response = await fetch('{{ route("admin.chats.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ user_id: currentUserId, message: message })
            });

            const data = await response.json();
            if (data && data.success) {
                appendMessage(
                    data.message.message,
                    true,
                    'Admin',
                    'Vừa xong',
                    data.message.id
                );
                input.value = '';
                input.focus();
            } else {
                console.error('Chat send failed:', data);
                alert('Không thể gửi tin nhắn. Vui lòng thử lại.');
            }
        } catch (err) {
            console.error('Chat error:', err);
            alert('Lỗi kết nối. Vui lòng thử lại.');
        } finally {
            sendBtn.disabled = false;
            sendBtn.innerHTML = originalContent;
        }
    });

    // Enter to send
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            form.dispatchEvent(new Event('submit'));
        }
    });

    // Back to list (mobile)
    if (backToListBtn) {
        backToListBtn.addEventListener('click', function() {
            window.location.href = '{{ route("admin.chats.index") }}';
        });
    }

    // Focus input on load
    input.focus();
})();
</script>
@endpush
