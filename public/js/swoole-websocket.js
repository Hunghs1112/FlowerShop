/**
 * FlowerShop Swoole WebSocket Client
 * 
 * Native WebSocket client for connecting to Swoole server
 * Usage: import { SwooleWebSocket } from './swoole-websocket.js'
 */

class SwooleWebSocket {
    constructor(config = {}) {
        this.config = {
            host: config.host || window.location.hostname,
            port: config.port || 9501,
            secure: config.secure ?? (window.location.protocol === 'https:'),
            reconnectInterval: config.reconnectInterval || 3000,
            maxReconnectAttempts: config.maxReconnectAttempts || 10,
            debug: config.debug ?? true,
            ...config
        };

        this.ws = null;
        this.reconnectAttempts = 0;
        this.connected = false;
        this.subscriptions = new Map();
        this.eventHandlers = new Map();
        this.connectionPromise = null;
    }

    /**
     * Connect to Swoole WebSocket server
     */
    connect() {
        if (this.connectionPromise) {
            return this.connectionPromise;
        }

        this.connectionPromise = new Promise((resolve, reject) => {
            const protocol = this.config.secure ? 'wss' : 'ws';
            const url = `${protocol}://${this.config.host}:${this.config.port}`;

            this.log('Connecting to', url);

            try {
                this.ws = new WebSocket(url);

                this.ws.onopen = (event) => {
                    this.connected = true;
                    this.reconnectAttempts = 0;
                    this.log('✅ Connected to Swoole WebSocket');
                    this.trigger('connect', event);
                    resolve(this);
                    this.connectionPromise = null;

                    // Resubscribe to channels after reconnect
                    this.resubscribeAll();
                };

                this.ws.onmessage = (event) => {
                    try {
                        const data = JSON.parse(event.data);
                        this.handleMessage(data);
                    } catch (error) {
                        this.log('Failed to parse message:', error);
                    }
                };

                this.ws.onerror = (error) => {
                    this.log('❌ WebSocket error:', error);
                    this.trigger('error', error);
                };

                this.ws.onclose = (event) => {
                    this.connected = false;
                    this.log('Disconnected from Swoole WebSocket');
                    this.trigger('disconnect', event);
                    this.connectionPromise = null;

                    // Attempt reconnect
                    if (this.reconnectAttempts < this.config.maxReconnectAttempts) {
                        this.reconnect();
                    } else {
                        this.log('Max reconnect attempts reached');
                        this.trigger('reconnect_failed');
                    }
                };

                // Timeout fallback
                setTimeout(() => {
                    if (!this.connected) {
                        this.log('Connection timeout');
                        reject(new Error('Connection timeout'));
                        this.ws.close();
                        this.connectionPromise = null;
                    }
                }, 10000);

            } catch (error) {
                this.log('Connection error:', error);
                reject(error);
                this.connectionPromise = null;
            }
        });

        return this.connectionPromise;
    }

    /**
     * Handle incoming WebSocket message
     */
    handleMessage(data) {
        this.log('📩 Message:', data);

        switch (data.type) {
            case 'connected':
                this.log('Server welcome:', data.message);
                break;

            case 'subscription_succeeded':
                this.log(`✓ Subscribed to channel: ${data.channel}`);
                this.trigger('subscription_succeeded', data);
                break;

            case 'unsubscribed':
                this.log(`✓ Unsubscribed from channel: ${data.channel}`);
                this.trigger('unsubscribed', data);
                break;

            case 'message':
                this.handleChannelMessage(data);
                break;

            case 'pong':
                this.log('Pong received');
                break;

            case 'error':
                this.log('Server error:', data.message);
                this.trigger('error', data);
                break;

            default:
                this.log('Unknown message type:', data.type);
        }
    }

    /**
     * Handle channel message (Laravel broadcast)
     */
    handleChannelMessage(data) {
        const { channel, event: eventName, data: eventData } = data;

        // Trigger channel-specific listeners
        const listeners = this.subscriptions.get(channel);
        if (listeners) {
            listeners.forEach(callback => {
                try {
                    callback(eventData, eventName);
                } catch (error) {
                    this.log('Listener error:', error);
                }
            });
        }

        // Trigger global event listeners
        const eventListeners = this.eventHandlers.get(eventName);
        if (eventListeners) {
            eventListeners.forEach(callback => {
                try {
                    callback(eventData, channel);
                } catch (error) {
                    this.log('Event listener error:', error);
                }
            });
        }
    }

    /**
     * Subscribe to a channel
     */
    channel(channelName) {
        return new Channel(this, channelName);
    }

    /**
     * Send subscription request to server
     */
    subscribe(channelName, callback) {
        if (!this.subscriptions.has(channelName)) {
            this.subscriptions.set(channelName, new Set());
        }

        if (callback) {
            this.subscriptions.get(channelName).add(callback);
        }

        if (this.connected) {
            this.send({
                type: 'subscribe',
                channel: channelName
            });
        }

        return this;
    }

    /**
     * Unsubscribe from a channel
     */
    unsubscribe(channelName, callback = null) {
        if (callback && this.subscriptions.has(channelName)) {
            this.subscriptions.get(channelName).delete(callback);
            
            // If no more listeners, unsubscribe completely
            if (this.subscriptions.get(channelName).size === 0) {
                this.subscriptions.delete(channelName);
            }
        } else {
            this.subscriptions.delete(channelName);
        }

        if (this.connected && !this.subscriptions.has(channelName)) {
            this.send({
                type: 'unsubscribe',
                channel: channelName
            });
        }

        return this;
    }

    /**
     * Listen for specific event type
     */
    listen(eventName, callback) {
        if (!this.eventHandlers.has(eventName)) {
            this.eventHandlers.set(eventName, new Set());
        }
        this.eventHandlers.get(eventName).add(callback);
        return this;
    }

    /**
     * Send message to server
     */
    send(data) {
        if (this.connected && this.ws.readyState === WebSocket.OPEN) {
            this.ws.send(JSON.stringify(data));
        } else {
            this.log('Cannot send: not connected');
        }
    }

    /**
     * Ping server (heartbeat)
     */
    ping() {
        this.send({ type: 'ping' });
    }

    /**
     * Reconnect to server
     */
    reconnect() {
        this.reconnectAttempts++;
        this.log(`Reconnecting... (attempt ${this.reconnectAttempts}/${this.config.maxReconnectAttempts})`);
        
        setTimeout(() => {
            this.connect();
        }, this.config.reconnectInterval);
    }

    /**
     * Resubscribe to all channels after reconnect
     */
    resubscribeAll() {
        this.subscriptions.forEach((listeners, channelName) => {
            this.send({
                type: 'subscribe',
                channel: channelName
            });
        });
    }

    /**
     * Register global event handler
     */
    on(event, callback) {
        if (!this.eventHandlers.has(event)) {
            this.eventHandlers.set(event, new Set());
        }
        this.eventHandlers.get(event).add(callback);
        return this;
    }

    /**
     * Trigger event handlers
     */
    trigger(event, data) {
        const handlers = this.eventHandlers.get(event);
        if (handlers) {
            handlers.forEach(callback => {
                try {
                    callback(data);
                } catch (error) {
                    this.log('Event handler error:', error);
                }
            });
        }
    }

    /**
     * Disconnect from server
     */
    disconnect() {
        this.config.maxReconnectAttempts = 0; // Disable auto-reconnect
        if (this.ws) {
            this.ws.close();
            this.ws = null;
        }
        this.connected = false;
        this.subscriptions.clear();
    }

    /**
     * Log messages (if debug enabled)
     */
    log(...args) {
        if (this.config.debug) {
            console.log('[SwooleWS]', ...args);
        }
    }
}

/**
 * Channel wrapper (Laravel Echo-like API)
 */
class Channel {
    constructor(socket, channelName) {
        this.socket = socket;
        this.channelName = channelName;
        this.listeners = new Map();
    }

    listen(eventName, callback) {
        // Subscribe to channel if not already
        const wrapper = (data, event) => {
            if (event === eventName || event === `App\\Events\\${eventName}`) {
                callback(data);
            }
        };
        this.socket.subscribe(this.channelName, wrapper);

        // Store listener for cleanup
        if (!this.listeners.has(eventName)) {
            this.listeners.set(eventName, []);
        }
        this.listeners.get(eventName).push({ callback, wrapper });

        return this;
    }

    stopListening(eventName) {
        const listeners = this.listeners.get(eventName) || [];
        for (const { wrapper } of listeners) this.socket.unsubscribe(this.channelName, wrapper);
        this.listeners.delete(eventName);
        return this;
    }

    leave() {
        this.socket.unsubscribe(this.channelName);
        this.listeners.clear();
    }
}

/**
 * Create global instance (Laravel Echo-style)
 */
window.SwooleWebSocket = SwooleWebSocket;

/**
 * Export for module usage
 */
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { SwooleWebSocket, Channel };
}

export { SwooleWebSocket, Channel };
