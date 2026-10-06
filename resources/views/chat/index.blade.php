@extends('layouts.app')

@section('title', 'Chat với Admin')

@section('content')
<div class="chat-page">
    <div class="chat-container">
        {{-- Header --}}
        <div class="chat-header">
            <div class="chat-header-info">
                <div class="chat-header-avatar">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zZ"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="chat-header-text">
                    <h1 class="chat-header-title">Chat với Admin</h1>
                    <p class="chat-header-subtitle">Chúng tôi sẵn sàng hỗ trợ bạn</p>
                </div>
            </div>
            <span class="chat-status connected" id="connectionStatus">
                <span class="status-dot"></span>
                <span class="status-text">Đã kết nối</span>
            </span>
        </div>

        {{-- Messages List --}}
        <div class="chat-messages" id="chatMessages">
            @forelse($messages as $message)
                <div class="chat-message {{ $message->is_admin ? 'admin' : 'user' }}" data-message-id="{{ $message->id }}">
                    @if($message->is_admin)
                        <div class="chat-message-avatar">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
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
                    <h3 class="chat-empty-title">Bắt đầu cuộc trò chuyện</h3>
                    <p class="chat-empty-text">Hãy gửi tin nhắn cho chúng tôi, đội ngũ hỗ trợ sẽ phản hồi trong thời gian sớm nhất.</p>
                </div>
            @endforelse
        </div>

        {{-- Input Form --}}
        <form class="chat-input-form" id="chatForm" autocomplete="off">
            @csrf
            <input
                type="text"
                id="messageInput"
                class="chat-input"
                placeholder="Nhập tin nhắn của bạn..."
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
    </div>
</div>
@endsection

@push('scripts')
{{-- Simple Polling for Local Dev (No WebSocket Required) --}}
<script src="{{ asset('js/chat-polling.js') }}"></script>
<script>
(function() {
    'use strict';

    const messagesDiv = document.getElementById('chatMessages');
    const form = document.getElementById('chatForm');
    const input = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');
    const emptyState = document.getElementById('emptyState');

    // Get last message ID from page
    let lastMessageId = 0;
    const lastMessage = document.querySelector('[data-message-id]:last-child');
    if (lastMessage) {
        lastMessageId = parseInt(lastMessage.dataset.messageId) || 0;
    }

    // === Auto-scroll on load ===
    function scrollToBottom() {
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }
    scrollToBottom();

    // === Escape HTML to prevent XSS ===
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // === Append message to DOM ===
    function appendMessage(data) {
        // Hide empty state if present
        if (emptyState && emptyState.parentNode) {
            emptyState.remove();
        }

        // Check if message already exists
        if (data.id && document.querySelector('[data-message-id="' + data.id + '"]')) {
            return;
        }

        const wrapper = document.createElement('div');
        wrapper.className = 'chat-message ' + (data.is_admin ? 'admin' : 'user');
        if (data.id) {
            wrapper.setAttribute('data-message-id', data.id);
        }

        if (data.is_admin) {
            const avatar = document.createElement('div');
            avatar.className = 'chat-message-avatar';
            avatar.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>';
            wrapper.appendChild(avatar);
        }

        const bubble = document.createElement('div');
        bubble.className = 'message-bubble';
        bubble.innerHTML =
            '<div class="message-text">' + escapeHtml(data.message) + '</div>' +
            '<div class="message-time">' + escapeHtml(data.created_at || 'Vừa xong') + '</div>';
        wrapper.appendChild(bubble);

        messagesDiv.appendChild(wrapper);
        scrollToBottom();
    }

    // === Initialize Chat Polling ===
    const chatPolling = new ChatPolling({
        interval: 3000, // Poll every 3 seconds
        endpoint: '{{ route("chat.poll") }}',
        onNewMessage: function(message) {
            console.log('📩 New message:', message);
            appendMessage(message);
            
            // Update last message ID
            if (message.id > lastMessageId) {
                lastMessageId = message.id;
            }
        },
        onError: function(error) {
            console.error('Polling error:', error);
        },
        debug: {{ config('app.debug') ? 'true' : 'false' }}
    });

    // Set initial last message ID
    chatPolling.setLastMessageId(lastMessageId);

    // Start polling
    chatPolling.start({{ auth()->id() }});

    // === Send message handler ===
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;

        sendBtn.disabled = true;
        const originalContent = sendBtn.innerHTML;
        sendBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="spinner"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"/><path d="M12 2a10 10 0 0110 10"/></svg>';

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
            if (data && data.success) {
                // Append user's own message immediately
                appendMessage({
                    id: data.message.id,
                    message: data.message.message,
                    is_admin: false,
                    created_at: 'Vừa xong'
                });
                
                // Update last message ID
                if (data.message.id > lastMessageId) {
                    lastMessageId = data.message.id;
                    chatPolling.setLastMessageId(lastMessageId);
                }
                
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

    // Stop polling on page unload
    window.addEventListener('beforeunload', function() {
        chatPolling.stop();
    });

    // Focus input on load
    input.focus();
})();
</script>
@endpush
