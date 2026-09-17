/**
 * Simple Chat Polling - No WebSocket Required
 * For local development without Redis/Swoole
 */

class ChatPolling {
    constructor(config = {}) {
        this.config = {
            interval: config.interval || 3000, // Poll every 3 seconds
            endpoint: config.endpoint || '/api/chat/messages',
            onNewMessage: config.onNewMessage || null,
            onError: config.onError || null,
            debug: config.debug ?? true,
            ...config
        };

        this.lastMessageId = 0;
        this.isPolling = false;
        this.pollTimer = null;
        this.retryCount = 0;
        this.maxRetries = 5;
    }

    /**
     * Start polling
     */
    start(userId) {
        if (this.isPolling) {
            this.log('Polling already started');
            return;
        }

        this.userId = userId;
        this.isPolling = true;
        this.log('✅ Starting chat polling for user:', userId);
        
        // Initial fetch
        this.fetchMessages();
        
        // Start interval
        this.pollTimer = setInterval(() => {
            this.fetchMessages();
        }, this.config.interval);
    }

    /**
     * Stop polling
     */
    stop() {
        if (!this.isPolling) return;
        
        this.isPolling = false;
        if (this.pollTimer) {
            clearInterval(this.pollTimer);
            this.pollTimer = null;
        }
        this.log('⏸️ Polling stopped');
    }

    /**
     * Fetch new messages from server
     */
    async fetchMessages() {
        if (!this.isPolling) return;

        try {
            const url = `${this.config.endpoint}?user_id=${this.userId}&after=${this.lastMessageId}`;
            
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            const data = await response.json();
            
            // Reset retry count on success
            this.retryCount = 0;

            if (data.messages && data.messages.length > 0) {
                this.log(`📩 Received ${data.messages.length} new message(s)`);
                
                data.messages.forEach(message => {
                    // Update last message ID
                    if (message.id > this.lastMessageId) {
                        this.lastMessageId = message.id;
                    }

                    // Trigger callback
                    if (this.config.onNewMessage) {
                        this.config.onNewMessage(message);
                    }
                });
            }

        } catch (error) {
            this.retryCount++;
            this.log(`❌ Polling error (attempt ${this.retryCount}/${this.maxRetries}):`, error);
            
            if (this.config.onError) {
                this.config.onError(error);
            }

            // Stop polling after max retries
            if (this.retryCount >= this.maxRetries) {
                this.log('❌ Max retries reached. Stopping polling.');
                this.stop();
            }
        }
    }

    /**
     * Set last message ID manually
     */
    setLastMessageId(id) {
        this.lastMessageId = id;
        this.log('Last message ID set to:', id);
    }

    /**
     * Log messages (if debug enabled)
     */
    log(...args) {
        if (this.config.debug) {
            console.log('[ChatPolling]', ...args);
        }
    }
}

// Export for use
window.ChatPolling = ChatPolling;

if (typeof module !== 'undefined' && module.exports) {
    module.exports = { ChatPolling };
}
