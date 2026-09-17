# Swoole WebSocket Quick Start Guide

## 🚀 Bắt đầu nhanh (Local Development)

### 1. Start Redis (nếu chưa chạy)

```bash
# Windows (nếu có Redis installed)
redis-server

# Linux/Mac
sudo service redis-start
# hoặc
redis-server
```

### 2. Start Swoole WebSocket Server

```bash
php artisan swoole:serve start
```

**Output mong đợi:**
```
🚀 Swoole WebSocket Server started at 0.0.0.0:9501
📡 Redis subscriber listening on 127.0.0.1:6379
```

### 3. Test kết nối

**Option A: Browser Console (F12)**

```javascript
// Tạo WebSocket connection
const ws = new WebSocket('ws://localhost:9501');

ws.onopen = () => console.log('✅ Connected');
ws.onmessage = (e) => console.log('📩 Message:', JSON.parse(e.data));

// Subscribe to channel
ws.send(JSON.stringify({
    type: 'subscribe',
    channel: 'chat.1'
}));

// Test ping
ws.send(JSON.stringify({ type: 'ping' }));
```

**Option B: PowerShell Test Script**

```bash
powershell .\test-swoole.ps1
```

### 4. Test từ Laravel

```bash
php artisan tinker
```

```php
// Test broadcast
use App\Events\MessageSent;
use App\Models\Message;

$message = Message::first();
broadcast(new MessageSent($message));
```

Browser console sẽ nhận được message ngay lập tức!

---

## 📦 Deployment trên cPanel

### Bước 1: Upload files

Upload các file sau lên cPanel:

```
/home/your-user/public_html/
├── app/Services/SwooleWebSocketServer.php
├── app/Console/Commands/SwooleServe.php
├── app/Console/Commands/SwooleEnsureRunning.php
├── config/swoole.php
├── public/js/swoole-websocket.js
└── resources/views/partials/swoole-websocket.blade.php
```

### Bước 2: Cấu hình .env

```env
BROADCAST_CONNECTION=redis

SWOOLE_HOST=0.0.0.0
SWOOLE_PORT=9501
SWOOLE_WORKER_NUM=4
SWOOLE_TASK_WORKER_NUM=4

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

### Bước 3: Clear cache

```bash
php artisan config:clear
php artisan cache:clear
```

### Bước 4: Mở port 9501

**Option A: Qua cPanel → Firewall**
- Add port 9501 TCP

**Option B: Contact hosting support**
```
Hi, please open port 9501 for WebSocket connections.
```

### Bước 5: Start Swoole server

```bash
php artisan swoole:serve start
```

**Để chạy background:**

```bash
nohup php artisan swoole:serve start > /dev/null 2>&1 &
```

### Bước 6: Setup auto-restart (Supervisor hoặc Cron)

**Option A: Supervisor (nếu có)**

```bash
# Upload supervisor/swoole-websocket.conf
# Thay YOUR_CPANEL_USER bằng username thật

sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start flowershop-swoole-websocket
```

**Option B: Cron job (simple)**

cPanel → Cron Jobs → Add:

```bash
*/5 * * * * cd /home/your-user/public_html && php artisan swoole:ensure-running >> /dev/null 2>&1
```

Command này check mỗi 5 phút, nếu Swoole chết thì tự động restart.

### Bước 7: Test production

```bash
# Check status
php artisan swoole:serve status

# Check logs
tail -f storage/logs/swoole.log

# Check process
ps aux | grep swoole

# Check port
netstat -tulpn | grep 9501
```

---

## 🎨 Tích hợp vào Views

### Cách 1: Include partial (Recommended)

Trong `resources/views/layouts/app.blade.php`:

```blade
@include('partials.swoole-websocket')
```

### Cách 2: Manual setup

```blade
<script src="{{ asset('js/swoole-websocket.js') }}"></script>

<script>
    const swoole = new SwooleWebSocket({
        host: '{{ config('app.url') }}',
        port: {{ env('SWOOLE_PORT', 9501) }},
        secure: {{ request()->secure() ? 'true' : 'false' }},
    });

    swoole.connect();

    // Subscribe to chat
    swoole.channel('chat.{{ $chatId }}')
        .listen('MessageSent', (data) => {
            appendMessage(data.message);
        });
</script>
```

---

## 🔧 Quản lý Server

### Start server

```bash
php artisan swoole:serve start
```

### Stop server

```bash
php artisan swoole:serve stop
```

### Restart server

```bash
php artisan swoole:serve restart
```

### Check status

```bash
php artisan swoole:serve status
```

### Logs

```bash
# Real-time logs
tail -f storage/logs/swoole.log

# Last 50 lines
tail -n 50 storage/logs/swoole.log

# Search for errors
grep ERROR storage/logs/swoole.log
```

---

## 🐛 Troubleshooting

### ❌ "Connection refused"

**Nguyên nhân:**
- Swoole server chưa chạy
- Port 9501 bị firewall block

**Fix:**
```bash
# Check process
ps aux | grep swoole

# Start server
php artisan swoole:serve start

# Check firewall
sudo ufw status
sudo ufw allow 9501/tcp
```

### ❌ "Redis connection failed"

**Nguyên nhân:**
- Redis service chưa chạy
- Redis config sai

**Fix:**
```bash
# Check Redis
redis-cli ping
# Expected: PONG

# Check .env
cat .env | grep REDIS

# Clear config
php artisan config:clear
```

### ❌ "Cannot subscribe to channel"

**Nguyên nhân:**
- WebSocket chưa connected
- Channel name sai format

**Fix:**
```javascript
// Check connection first
console.log(swoole.connected); // should be true

// Debug subscribe
swoole.on('subscription_succeeded', (data) => {
    console.log('Subscribed:', data.channel);
});
```

### ❌ "Swoole stops after a while"

**Nguyên nhân:**
- Hosting kill long-running processes
- Cần Supervisor hoặc Cron monitor

**Fix:**
```bash
# Option 1: Setup Supervisor (best)
# Upload supervisor/swoole-websocket.conf

# Option 2: Cron check (simple)
*/5 * * * * php artisan swoole:ensure-running
```

### ❌ "Messages not received"

**Nguyên nhân:**
- Laravel broadcast event chưa config đúng
- Redis channel name không khớp

**Fix:**
```php
// Check event implements ShouldBroadcast
class MessageSent implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public function broadcastOn() {
        return new Channel('chat.' . $this->message->chat_id);
    }
}

// Test broadcast
php artisan tinker
broadcast(new MessageSent($message));
```

---

## 📊 Performance Tips

### 1. Tăng workers

```env
SWOOLE_WORKER_NUM=8
SWOOLE_TASK_WORKER_NUM=8
```

### 2. Redis optimization

```env
REDIS_DB=1  # Separate DB for broadcasting
```

### 3. Connection pooling

Swoole tự động handle connection pooling.

### 4. Monitor connections

```bash
# Check stats
php artisan swoole:serve status

# Count active connections
netstat -an | grep :9501 | wc -l
```

---

## 🔒 Security

### 1. Firewall rules

Chỉ mở port 9501 cho:
- Your server IP
- Cloudflare IPs (nếu dùng)

### 2. Authentication

```javascript
// Send auth token khi subscribe
swoole.channel('private-chat.1')
    .listen('MessageSent', callback);

// Server verify token trong SwooleWebSocketServer
```

### 3. Rate limiting

Thêm vào `SwooleWebSocketServer.php`:

```php
protected array $rateLimits = [];

protected function checkRateLimit(int $fd): bool {
    $now = time();
    $this->rateLimits[$fd] = $this->rateLimits[$fd] ?? [];
    $this->rateLimits[$fd] = array_filter(
        $this->rateLimits[$fd], 
        fn($t) => $now - $t < 60
    );
    
    if (count($this->rateLimits[$fd]) > 100) {
        return false; // Too many requests
    }
    
    $this->rateLimits[$fd][] = $now;
    return true;
}
```

---

## ✅ Production Checklist

- [ ] Redis service đang chạy
- [ ] Port 9501 đã mở
- [ ] Swoole server start với Supervisor/Cron
- [ ] SSL certificate cho wss:// (production)
- [ ] Logs rotation setup
- [ ] Monitoring alerts
- [ ] Rate limiting enabled
- [ ] Authentication implemented
- [ ] Load test completed

---

## 🎯 Next Steps

1. **Test local** → `php artisan swoole:serve start`
2. **Deploy lên cPanel** → upload files + config
3. **Setup monitoring** → Supervisor/Cron
4. **Test production** → browser connection
5. **Optimize** → workers, Redis config

---

## 📞 Support

- **Logs**: `storage/logs/swoole.log`
- **Status**: `php artisan swoole:serve status`
- **Test script**: `powershell test-swoole.ps1`
- **Documentation**: `SWOOLE_WEBSOCKET_SETUP.md`

**Có vấn đề?** Check logs trước, sau đó ping tôi!
