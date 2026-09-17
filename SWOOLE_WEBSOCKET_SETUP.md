# Swoole WebSocket Setup Guide

> 🚀 Chạy real-time WebSocket server trực tiếp trên cPanel hosting (không cần VPS riêng)

## Architecture Overview

```
┌────────────────────────────────────────────────────┐
│              cPanel Hosting                        │
├────────────────────────────────────────────────────┤
│                                                    │
│  Laravel App (HTTP)  ←──┐                         │
│         ↓                │                         │
│    Redis (Pub/Sub)  ────┤                         │
│         ↓                │                         │
│  Swoole WebSocket   ←────┘                        │
│    (port 9501)                                     │
│         ↓                                          │
└─────────┼──────────────────────────────────────────┘
          │
     WebSocket
          │
    ┌─────┴─────┐
    │  Browser  │
    └───────────┘
```

**Flow:**
1. User gửi chat → Laravel Controller
2. Laravel save DB → broadcast event → Redis
3. Swoole server subscribe Redis → nhận event
4. Swoole push message → tất cả connected clients qua WebSocket
5. Browser nhận instant update

---

## Prerequisites Check

✅ Bạn đã có:
- PHP 8.3 ✅
- Swoole extension ✅
- Redis extension ✅
- pcntl extension ✅

---

## Step 1: Install Dependencies

### A. Composer packages

```bash
cd /home/your-cpanel-user/public_html

# Install Redis client cho Laravel
composer require predis/predis

# Hoặc dùng phpredis (nếu prefer native extension)
# composer require predis/predis không cần nếu dùng phpredis extension
```

### B. Check Redis service

```bash
# Check Redis có chạy không
redis-cli ping
# Expected output: PONG

# Nếu chưa có, contact hosting support để enable Redis service
```

---

## Step 2: Laravel Configuration

### A. Update `.env`

```env
# Broadcasting
BROADCAST_CONNECTION=redis

# Redis configuration
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_DB=0

# Swoole WebSocket
SWOOLE_HOST=0.0.0.0
SWOOLE_PORT=9501
SWOOLE_MODE=SWOOLE_PROCESS
SWOOLE_SOCK_TYPE=SWOOLE_SOCK_TCP
```

### B. Update `config/broadcasting.php`

Đã có sẵn Redis driver, chỉ cần đảm bảo:

```php
'redis' => [
    'driver' => 'redis',
    'connection' => 'default',
],
```

### C. Clear cache

```bash
php artisan config:clear
php artisan cache:clear
```

---

## Step 3: Create Swoole WebSocket Server

### A. Create server script: `app/Services/SwooleWebSocketServer.php`

```php
<?php

namespace App\Services;

use Swoole\WebSocket\Server;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class SwooleWebSocketServer
{
    protected Server $server;
    protected array $clients = [];
    protected array $channels = [];

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
        ]);
    }

    public function start(): void
    {
        // Event: Server start
        $this->server->on('start', function (Server $server) {
            Log::info("Swoole WebSocket Server started at {$server->host}:{$server->port}");
        });

        // Event: New connection
        $this->server->on('open', function (Server $server, Request $request) {
            Log::info("Client {$request->fd} connected");
            $this->clients[$request->fd] = [
                'fd' => $request->fd,
                'channels' => [],
                'connected_at' => time(),
            ];
        });

        // Event: Receive message
        $this->server->on('message', function (Server $server, Frame $frame) {
            $this->handleMessage($server, $frame);
        });

        // Event: Connection close
        $this->server->on('close', function (Server $server, int $fd) {
            Log::info("Client {$fd} disconnected");
            $this->removeClient($fd);
        });

        // Event: Task (for Redis subscriber)
        $this->server->on('task', function (Server $server, int $taskId, int $fromWorkerId, $data) {
            // Broadcast message to subscribed clients
            $this->broadcastToChannel($data['channel'], $data['message']);
            return true;
        });

        $this->server->on('finish', function (Server $server, int $taskId, $data) {
            // Task finished
        });

        // Start Redis subscriber in worker process
        $this->server->on('workerStart', function (Server $server, int $workerId) {
            if ($workerId === 0) {
                $this->startRedisSubscriber($server);
            }
        });

        Log::info("Starting Swoole WebSocket Server...");
        $this->server->start();
    }

    protected function handleMessage(Server $server, Frame $frame): void
    {
        $data = json_decode($frame->data, true);
        
        if (!$data || !isset($data['type'])) {
            $server->push($frame->fd, json_encode(['error' => 'Invalid message format']));
            return;
        }

        match ($data['type']) {
            'subscribe' => $this->subscribeChannel($frame->fd, $data['channel'] ?? null),
            'unsubscribe' => $this->unsubscribeChannel($frame->fd, $data['channel'] ?? null),
            'ping' => $server->push($frame->fd, json_encode(['type' => 'pong'])),
            default => null,
        };
    }

    protected function subscribeChannel(int $fd, ?string $channel): void
    {
        if (!$channel) {
            return;
        }

        if (!isset($this->channels[$channel])) {
            $this->channels[$channel] = [];
        }

        $this->channels[$channel][$fd] = true;
        $this->clients[$fd]['channels'][] = $channel;

        Log::info("Client {$fd} subscribed to channel: {$channel}");
        
        $this->server->push($fd, json_encode([
            'type' => 'subscription_succeeded',
            'channel' => $channel,
        ]));
    }

    protected function unsubscribeChannel(int $fd, ?string $channel): void
    {
        if (!$channel || !isset($this->channels[$channel][$fd])) {
            return;
        }

        unset($this->channels[$channel][$fd]);
        $this->clients[$fd]['channels'] = array_diff($this->clients[$fd]['channels'], [$channel]);

        Log::info("Client {$fd} unsubscribed from channel: {$channel}");
    }

    protected function removeClient(int $fd): void
    {
        if (!isset($this->clients[$fd])) {
            return;
        }

        // Remove from all channels
        foreach ($this->clients[$fd]['channels'] as $channel) {
            if (isset($this->channels[$channel][$fd])) {
                unset($this->channels[$channel][$fd]);
            }
        }

        unset($this->clients[$fd]);
    }

    protected function broadcastToChannel(string $channel, array $message): void
    {
        if (!isset($this->channels[$channel])) {
            return;
        }

        $payload = json_encode([
            'type' => 'message',
            'channel' => $channel,
            'data' => $message,
        ]);

        foreach ($this->channels[$channel] as $fd => $true) {
            if ($this->server->isEstablished($fd)) {
                $this->server->push($fd, $payload);
            }
        }

        Log::info("Broadcasted to channel {$channel}: " . count($this->channels[$channel]) . " clients");
    }

    protected function startRedisSubscriber(Server $server): void
    {
        go(function () use ($server) {
            try {
                $redis = new \Redis();
                $redis->connect(config('database.redis.default.host'), config('database.redis.default.port'));
                
                if ($password = config('database.redis.default.password')) {
                    $redis->auth($password);
                }

                $redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);

                Log::info("Redis subscriber started, listening on channel pattern: *");

                // Subscribe to all Laravel broadcast channels
                $redis->psubscribe(['*'], function ($redis, $pattern, $channel, $message) use ($server) {
                    $data = json_decode($message, true);
                    
                    if (!$data) {
                        return;
                    }

                    // Extract channel name (Laravel prefixes with database name)
                    $channelName = str_replace(config('database.redis.default.database', 'laravel_database') . ':', '', $channel);

                    // Dispatch to task worker for broadcasting
                    $server->task([
                        'channel' => $channelName, 
                        'message' => $data,
                    ]);
                });
            } catch (\Exception $e) {
                Log::error("Redis subscriber error: " . $e->getMessage());
            }
        });
    }
}
```

### B. Create config file: `config/swoole.php`

```php
<?php

return [
    'host' => env('SWOOLE_HOST', '0.0.0.0'),
    'port' => env('SWOOLE_PORT', 9501),
    'mode' => SWOOLE_PROCESS,
    'sock_type' => SWOOLE_SOCK_TCP,
];
```

### C. Create Artisan command: `app/Console/Commands/SwooleServe.php`

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SwooleWebSocketServer;

class SwooleServe extends Command
{
    protected $signature = 'swoole:serve {action=start : start|stop|restart}';
    protected $description = 'Start Swoole WebSocket server';

    public function handle(): int
    {
        $action = $this->argument('action');

        match ($action) {
            'start' => $this->start(),
            'stop' => $this->stop(),
            'restart' => $this->restart(),
            default => $this->error("Invalid action: {$action}"),
        };

        return 0;
    }

    protected function start(): void
    {
        $this->info('Starting Swoole WebSocket Server...');
        
        $server = new SwooleWebSocketServer();
        $server->start();
    }

    protected function stop(): void
    {
        $this->info('Stopping Swoole WebSocket Server...');
        
        $pidFile = storage_path('app/swoole.pid');
        
        if (!file_exists($pidFile)) {
            $this->error('Swoole server is not running');
            return;
        }

        $pid = (int) file_get_contents($pidFile);
        
        if (posix_kill($pid, SIGTERM)) {
            unlink($pidFile);
            $this->info('Swoole server stopped');
        } else {
            $this->error('Failed to stop Swoole server');
        }
    }

    protected function restart(): void
    {
        $this->stop();
        sleep(2);
        $this->start();
    }
}
```

---

## Step 4: Frontend Configuration

### Update `resources/views/chat/index.blade.php` và `resources/views/admin/chats/show.blade.php`

Replace Echo config:

```javascript
// OLD (Pusher/Reverb)
window.Echo = new Echo({
    broadcaster: 'reverb',
    // ...
});

// NEW (Swoole)
window.Echo = new Echo({
    broadcaster: 'socket.io', // Dùng socket.io protocol adapter
    host: window.location.hostname + ':9501',
    transports: ['websocket'],
    
    // Hoặc native WebSocket (simpler)
    // broadcaster: 'pusher',
    // wsHost: window.location.hostname,
    // wsPort: 9501,
    // wssPort: 9501,
    // forceTLS: location.protocol === 'https:',
    // disableStats: true,
    // enabledTransports: ['ws', 'wss'],
});

// Connection status
window.Echo.connector.socket.on('connect', () => {
    console.log('✅ Connected to Swoole WebSocket');
    document.getElementById('connection-status')?.classList.add('connected');
});

window.Echo.connector.socket.on('disconnect', () => {
    console.log('❌ Disconnected from Swoole WebSocket');
    document.getElementById('connection-status')?.classList.remove('connected');
});

// Subscribe to chat channel
window.Echo.channel('chat.' + chatId)
    .listen('MessageSent', (e) => {
        console.log('New message:', e);
        appendMessage(e.message);
    });
```

---

## Step 5: Supervisor Configuration

### Create: `supervisor/swoole-websocket.conf`

```ini
[program:swoole-websocket]
process_name=%(program_name)s
command=php /home/your-cpanel-user/public_html/artisan swoole:serve start
autostart=true
autorestart=true
user=your-cpanel-user
numprocs=1
redirect_stderr=true
stdout_logfile=/home/your-cpanel-user/public_html/storage/logs/swoole-supervisor.log
stdout_logfile_maxbytes=10MB
stdout_logfile_backups=5
stopwaitsecs=10
```

### Install Supervisor (if not available)

Contact cPanel hosting support để enable Supervisor, hoặc:

```bash
# Check if available
supervisorctl status

# If not, use systemd or cron + process monitor
```

**Alternative: Cron + Process Monitor** (nếu không có Supervisor):

```bash
*/5 * * * * cd /home/your-cpanel-user/public_html && php artisan swoole:ensure-running >> /dev/null 2>&1
```

Create command `app/Console/Commands/SwooleEnsureRunning.php`:

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SwooleEnsureRunning extends Command
{
    protected $signature = 'swoole:ensure-running';
    protected $description = 'Ensure Swoole server is running (for cron)';

    public function handle(): int
    {
        $pidFile = storage_path('app/swoole.pid');
        
        if (file_exists($pidFile)) {
            $pid = (int) file_get_contents($pidFile);
            if (posix_kill($pid, 0)) {
                // Already running
                return 0;
            }
        }

        // Start server in background
        exec('cd ' . base_path() . ' && php artisan swoole:serve start > /dev/null 2>&1 &');
        
        return 0;
    }
}
```

---

## Step 6: Nginx Reverse Proxy (Optional but Recommended)

### A. Create: `.htaccess` proxy rule

Nếu dùng cPanel Apache + Nginx proxy:

```apache
# WebSocket proxy
RewriteEngine On
RewriteCond %{HTTP:Upgrade} websocket [NC]
RewriteCond %{HTTP:Connection} upgrade [NC]
RewriteRule ^/ws/?(.*) ws://127.0.0.1:9501/$1 [P,L]
```

### B. Hoặc config Nginx trực tiếp

File: `/etc/nginx/conf.d/websocket.conf` (cần root access hoặc contact support):

```nginx
upstream swoole_websocket {
    server 127.0.0.1:9501;
}

server {
    listen 443 ssl http2;
    server_name your-domain.com;

    # SSL certificates
    ssl_certificate /path/to/ssl/cert.pem;
    ssl_certificate_key /path/to/ssl/key.pem;

    # WebSocket location
    location /ws {
        proxy_pass http://swoole_websocket;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        
        # Timeouts
        proxy_connect_timeout 7d;
        proxy_send_timeout 7d;
        proxy_read_timeout 7d;
    }

    # Laravel app
    location / {
        # ... existing Laravel config
    }
}
```

---

## Step 7: Firewall Configuration

### Open port 9501 (if needed)

Contact cPanel support to open port 9501, or use CSF/firewall:

```bash
# CSF Firewall
csf -a 9501

# Or UFW
ufw allow 9501/tcp
```

---

## Step 8: Testing

### A. Start Swoole server

```bash
php artisan swoole:serve start
```

Check log:

```bash
tail -f storage/logs/swoole.log
```

### B. Test WebSocket connection

**Browser Console:**

```javascript
const ws = new WebSocket('ws://your-domain.com:9501');

ws.onopen = () => console.log('✅ Connected');
ws.onmessage = (e) => console.log('📩 Message:', e.data);
ws.onerror = (e) => console.error('❌ Error:', e);

// Subscribe to channel
ws.send(JSON.stringify({
    type: 'subscribe',
    channel: 'chat.1'
}));
```

### C. Test Laravel broadcast

**Tinker:**

```bash
php artisan tinker
```

```php
use App\Events\MessageSent;

$message = App\Models\Message::first();
broadcast(new MessageSent($message))->toOthers();
```

Check browser console → should see message instantly.

---

## Troubleshooting

### ❌ Connection refused

```bash
# Check if Swoole running
ps aux | grep swoole

# Check port listening
netstat -tulpn | grep 9501

# Check firewall
csf -g 9501
```

### ❌ Redis connection failed

```bash
# Check Redis service
redis-cli ping

# Check Redis config in .env
php artisan config:clear
```

### ❌ Supervisor not starting

```bash
# Check logs
tail -f storage/logs/swoole-supervisor.log

# Manually start
php artisan swoole:serve start

# Check permissions
ls -la storage/logs/
```

---

## Production Checklist

- [ ] Swoole server running với Supervisor
- [ ] Redis service active
- [ ] Port 9501 open (hoặc Nginx proxy /ws)
- [ ] SSL certificate cho WebSocket (wss://)
- [ ] Monitor logs: `storage/logs/swoole.log`
- [ ] Test reconnection khi server restart
- [ ] Load test với nhiều concurrent connections

---

## Performance Tuning

### A. Swoole config

```php
$this->server->set([
    'worker_num' => 8, // Increase workers
    'max_connection' => 10000,
    'buffer_output_size' => 32 * 1024 * 1024,
]);
```

### B. Redis optimization

```env
REDIS_DB=1  # Separate DB for broadcasting
```

---

## Monitoring

### Check connected clients

Add to `SwooleWebSocketServer`:

```php
public function getStats(): array
{
    return [
        'connections' => $this->server->stats()['connection_num'],
        'clients' => count($this->clients),
        'channels' => count($this->channels),
    ];
}
```

Expose via route:

```php
Route::get('/api/swoole/stats', function () {
    // Return cached stats from Redis
});
```

---

**Next Steps:**
1. Run `composer require predis/predis`
2. Create các files trên
3. Test local first
4. Deploy lên cPanel
5. Setup Supervisor/Cron
6. Test production

Có gì không hiểu hỏi tôi nhé! 🚀
