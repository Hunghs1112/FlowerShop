<?php

namespace App\Services;

use Swoole\WebSocket\Server;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
use Illuminate\Support\Facades\Log;

class SwooleWebSocketServer
{
    protected Server $server;
    protected array $clients = [];
    protected array $channels = [];
    protected ?\Redis $redis = null;

    public function __construct()
    {
        $host = config('swoole.host', '0.0.0.0');
        $port = config('swoole.port', 9501);
        
        $this->server = new Server($host, $port);
        
        // Configure server
        $this->server->set([
            'worker_num' => 4,
            'task_worker_num' => 4,
            'daemonize' => false,
            'log_file' => storage_path('logs/swoole.log'),
            'log_level' => SWOOLE_LOG_INFO,
            'heartbeat_check_interval' => 60,
            'heartbeat_idle_time' => 600,
            'max_connection' => 10000,
            'pid_file' => storage_path('app/swoole.pid'),
        ]);
    }

    public function start(): void
    {
        // Event: Server start
        $this->server->on('start', function (Server $server) {
            Log::info("Swoole WebSocket Server started at {$server->host}:{$server->port}");
            echo "🚀 Swoole WebSocket Server started at {$server->host}:{$server->port}\n";
        });

        // Event: New connection
        $this->server->on('open', function (Server $server, Request $request) {
            Log::info("Client {$request->fd} connected from {$request->server['remote_addr']}");
            $this->clients[$request->fd] = [
                'fd' => $request->fd,
                'channels' => [],
                'connected_at' => time(),
            ];
            
            // Send welcome message
            $server->push($request->fd, json_encode([
                'type' => 'connected',
                'message' => 'Welcome to FlowerShop WebSocket',
                'fd' => $request->fd,
            ]));
        });

        // Event: Receive message from client
        $this->server->on('message', function (Server $server, Frame $frame) {
            $this->handleMessage($server, $frame);
        });

        // Event: Connection close
        $this->server->on('close', function (Server $server, int $fd) {
            Log::info("Client {$fd} disconnected");
            $this->removeClient($fd);
        });

        // Event: Task worker (for broadcasting)
        $this->server->on('task', function (Server $server, int $taskId, int $fromWorkerId, $data) {
            if (isset($data['action']) && $data['action'] === 'broadcast') {
                $this->broadcastToChannel($data['channel'], $data['message']);
            }
            return true;
        });

        $this->server->on('finish', function (Server $server, int $taskId, $data) {
            // Task completed
        });

        // Start Redis subscriber in worker 0
        $this->server->on('workerStart', function (Server $server, int $workerId) {
            if ($workerId === 0) {
                $this->startRedisSubscriber($server);
            }
        });

        Log::info("Starting Swoole WebSocket Server...");
        $this->server->start();
    }

    /**
     * Handle incoming WebSocket message from client
     */
    protected function handleMessage(Server $server, Frame $frame): void
    {
        $data = json_decode($frame->data, true);
        
        if (!$data || !isset($data['type'])) {
            $server->push($frame->fd, json_encode([
                'type' => 'error',
                'message' => 'Invalid message format. Expected JSON with "type" field.',
            ]));
            return;
        }

        Log::debug("Message from client {$frame->fd}: " . $frame->data);

        match ($data['type']) {
            'subscribe' => $this->subscribeChannel($frame->fd, $data['channel'] ?? null),
            'unsubscribe' => $this->unsubscribeChannel($frame->fd, $data['channel'] ?? null),
            'ping' => $server->push($frame->fd, json_encode(['type' => 'pong', 'timestamp' => time()])),
            default => $server->push($frame->fd, json_encode([
                'type' => 'error',
                'message' => "Unknown message type: {$data['type']}",
            ])),
        };
    }

    /**
     * Subscribe client to a channel
     */
    protected function subscribeChannel(int $fd, ?string $channel): void
    {
        if (!$channel) {
            $this->server->push($fd, json_encode([
                'type' => 'error',
                'message' => 'Channel name is required',
            ]));
            return;
        }

        // Initialize channel if not exists
        if (!isset($this->channels[$channel])) {
            $this->channels[$channel] = [];
        }

        // Add client to channel
        $this->channels[$channel][$fd] = true;
        
        // Update client's subscribed channels
        if (!in_array($channel, $this->clients[$fd]['channels'])) {
            $this->clients[$fd]['channels'][] = $channel;
        }

        Log::info("Client {$fd} subscribed to channel: {$channel}");
        
        // Confirm subscription
        $this->server->push($fd, json_encode([
            'type' => 'subscription_succeeded',
            'channel' => $channel,
        ]));
    }

    /**
     * Unsubscribe client from a channel
     */
    protected function unsubscribeChannel(int $fd, ?string $channel): void
    {
        if (!$channel || !isset($this->channels[$channel][$fd])) {
            return;
        }

        unset($this->channels[$channel][$fd]);
        
        // Remove channel from client's list
        $this->clients[$fd]['channels'] = array_values(
            array_diff($this->clients[$fd]['channels'], [$channel])
        );

        Log::info("Client {$fd} unsubscribed from channel: {$channel}");
        
        $this->server->push($fd, json_encode([
            'type' => 'unsubscribed',
            'channel' => $channel,
        ]));
    }

    /**
     * Remove client and cleanup subscriptions
     */
    protected function removeClient(int $fd): void
    {
        if (!isset($this->clients[$fd])) {
            return;
        }

        // Remove from all subscribed channels
        foreach ($this->clients[$fd]['channels'] as $channel) {
            if (isset($this->channels[$channel][$fd])) {
                unset($this->channels[$channel][$fd]);
            }
        }

        unset($this->clients[$fd]);
    }

    /**
     * Broadcast message to all clients in a channel
     */
    protected function broadcastToChannel(string $channel, array $message): void
    {
        if (!isset($this->channels[$channel]) || empty($this->channels[$channel])) {
            Log::debug("No subscribers for channel: {$channel}");
            return;
        }

        $payload = json_encode([
            'type' => 'message',
            'channel' => $channel,
            'event' => $message['event'] ?? 'MessageSent',
            'data' => $message['data'] ?? $message,
        ]);

        $sent = 0;
        foreach ($this->channels[$channel] as $fd => $true) {
            if ($this->server->isEstablished($fd)) {
                $this->server->push($fd, $payload);
                $sent++;
            } else {
                // Remove dead connection
                unset($this->channels[$channel][$fd]);
            }
        }

        Log::info("Broadcasted to channel '{$channel}': {$sent} clients received");
    }

    /**
     * Start Redis subscriber to listen for Laravel broadcast events
     */
    protected function startRedisSubscriber(Server $server): void
    {
        go(function () use ($server) {
            try {
                $this->redis = new \Redis();
                $redisHost = config('database.redis.default.host', '127.0.0.1');
                $redisPort = config('database.redis.default.port', 6379);
                
                $this->redis->connect($redisHost, $redisPort);
                
                $redisPassword = config('database.redis.default.password');
                if ($redisPassword) {
                    $this->redis->auth($redisPassword);
                }

                // Set read timeout to -1 for blocking mode
                $this->redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);

                Log::info("Redis subscriber started. Listening for Laravel broadcast events...");
                echo "📡 Redis subscriber listening on {$redisHost}:{$redisPort}\n";

                // Subscribe to all Laravel broadcast channels
                // Laravel publishes to channels like: "laravel_database_chat.1"
                $this->redis->psubscribe(['*'], function ($redis, $pattern, $channel, $message) use ($server) {
                    try {
                        $data = json_decode($message, true);
                        
                        if (!$data) {
                            Log::warning("Invalid JSON from Redis: {$message}");
                            return;
                        }

                        // Extract channel name
                        // Laravel format: "database_prefix_channel_name"
                        $channelParts = explode(':', $channel);
                        $channelName = end($channelParts);

                        Log::debug("Redis event on channel '{$channelName}': " . json_encode($data));

                        // Dispatch to task worker for broadcasting
                        $server->task([
                            'action' => 'broadcast',
                            'channel' => $channelName,
                            'message' => $data,
                        ]);
                    } catch (\Exception $e) {
                        Log::error("Error processing Redis message: " . $e->getMessage());
                    }
                });
            } catch (\Exception $e) {
                Log::error("Redis subscriber error: " . $e->getMessage());
                echo "❌ Redis subscriber failed: " . $e->getMessage() . "\n";
                
                // Retry after 5 seconds
                sleep(5);
                $this->startRedisSubscriber($server);
            }
        });
    }

    /**
     * Get server statistics
     */
    public function getStats(): array
    {
        $stats = $this->server->stats();
        
        return [
            'total_connections' => $stats['connection_num'] ?? 0,
            'active_clients' => count($this->clients),
            'channels' => count($this->channels),
            'channel_details' => array_map(fn($subscribers) => count($subscribers), $this->channels),
            'start_time' => $stats['start_time'] ?? null,
            'worker_num' => $stats['worker_num'] ?? 0,
        ];
    }
}
