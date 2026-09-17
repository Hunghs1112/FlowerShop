# Reverb VPS Setup Guide

Hướng dẫn cài đặt Laravel Reverb WebSocket server trên VPS riêng (Ubuntu 22.04 LTS) để kết nối với Laravel app trên cPanel hosting.

> **Lưu ý**: Reverb server cần PHP 8.2+ và là một process PHP liên tục chạy trên port 8080. VPS phải có IP tĩnh hoặc domain/subdomain trỏ về.

---

## A. Chuẩn bị VPS

### 1. SSH vào VPS

```bash
ssh root@your-vps-ip
```

### 2. Cập nhật hệ thống

```bash
apt update && apt upgrade -y
```

### 3. Cài đặt PHP 8.2 + extensions cần thiết

```bash
# Thêm PPA cho PHP 8.2
add-apt-repository ppa:ondrej/php -y
apt update

# Cài PHP và các extension Reverb cần
apt install -y php8.2 php8.2-cli php8.2-mbstring php8.2-xml php8.2-curl php8.2-sqlite3 php8.2-zip php8.2-bcmath php8.2-sockets

# Verify
php -v
```

### 4. Cài Composer

```bash
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
composer --version
```

### 5. Cài Supervisor + Nginx + UFW

```bash
apt install -y supervisor nginx ufw
```

---

## B. Cài đặt Reverb standalone

### 1. Tạo project folder

```bash
mkdir -p /var/www/reverb-server
cd /var/www/reverb-server
```

### 2. Tạo minimal Laravel project

Có 2 cách. Cách A (khuyến nghị) là clone từ Git repo của bạn nhưng chỉ để chạy Reverb. Cách B là tạo project Laravel mới chỉ để host Reverb.

**Cách A — Dùng cùng repo với cPanel (khuyến nghị):**

```bash
# Clone project của bạn (chỉ cần source code, không cần public_html)
cd /var/www
git clone https://github.com/your-user/flowershop.git reverb-server
cd reverb-server

# Cài dependencies (production only để tiết kiệm RAM)
composer install --no-dev --optimize-autoloader

# Copy .env riêng cho Reverb server
cp .env.example .env
php artisan key:generate
```

**Cách B — Tạo project Laravel minimal riêng:**

```bash
cd /var/www/reverb-server
composer create-project laravel/laravel . "^11.0"

# Cài Reverb
composer require laravel/reverb
php artisan reverb:install
```

### 3. Cấu hình `.env` cho Reverb

Sửa file `/var/www/reverb-server/.env`:

```env
APP_NAME=ReverbServer
APP_ENV=production
APP_KEY=base64:GENERATE_KEY_HERE              # chạy: php artisan key:generate
APP_DEBUG=false
APP_URL=http://your-vps-ip:8080

# === Broadcasting ===
BROADCAST_CONNECTION=reverb

# === Reverb config ===
REVERB_APP_ID=flowershop-app                   # PHẢI GIỐNG với cPanel .env
REVERB_APP_KEY=flowershop-reverb-key-xxxxx     # PHẢI GIỐNG với cPanel .env
REVERB_APP_SECRET=flowershop-reverb-secret-yyy # PHẢI GIỐNG với cPanel .env
REVERB_HOST="0.0.0.0"
REVERB_PORT=8080
REVERB_SCHEME=http

# === Server (PHP) ===
REVERB_SERVER=reverb
REVERB_SERVER_HOST=0.0.0.0
REVERB_SERVER_PORT=8080
REVERB_SERVER_PATH=ws

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=info
```

**Quan trọng**: 3 giá trị `REVERB_APP_ID`, `REVERB_APP_KEY`, `REVERB_APP_SECRET` PHẢI GIỐNG HỆT trong cPanel `.env`, nếu không cPanel app sẽ không thể broadcast event sang Reverb server.

### 4. Generate app key

```bash
php artisan key:generate
```

### 5. Test chạy thử (foreground)

```bash
php artisan reverb:start --host=0.0.0.0 --port=8080
```

Nếu thấy log:
```
Starting Reverb server on 0.0.0.0:8080...
```

→ Ctrl+C để thoát, chuyển sang bước Supervisor.

Test từ máy local:
```bash
curl http://your-vps-ip:8080/health
# Expected: ok
```

---

## C. Supervisor config (keep Reverb alive)

Supervisor sẽ tự động restart Reverb nếu crash, và auto-start khi VPS reboot.

### 1. Tạo config file

```bash
nano /etc/supervisor/conf.d/reverb.conf
```

Nội dung:

```ini
[program:reverb]
process_name=%(program_name)s
command=php /var/www/reverb-server/artisan reverb:start --host=0.0.0.0 --port=8080
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/reverb-server/storage/logs/reverb.log
stdout_logfile_maxbytes=10MB
stdout_logfile_backups=5
stopwaitsecs=10
```

**Giải thích các tham số:**

| Tham số | Ý nghĩa |
|---------|----------|
| `command` | Lệnh chạy Reverb. Đảm bảo đường dẫn tuyệt đối. |
| `autostart=true` | Tự chạy khi Supervisor khởi động. |
| `autorestart=true` | Auto restart nếu crash. |
| `user=www-data` | User chạy process (nên match với web server). |
| `stdout_logfile` | File log (rotation 10MB x 5 files). |
| `stopwaitsecs=10` | Đợi 10s khi stop để cleanup connections. |
| `numprocs=1` | Chỉ chạy 1 process Reverb. Nếu cần scale thì tăng lên và dùng load balancer. |

### 2. Phân quyền

```bash
# Đảm bảo www-data có thể ghi log
chown -R www-data:www-data /var/www/reverb-server/storage
chmod -R 775 /var/www/reverb-server/storage
```

### 3. Reload Supervisor

```bash
supervisorctl reread
supervisorctl update
supervisorctl start reverb
supervisorctl status reverb
```

Output mong đợi:
```
reverb                           RUNNING   pid 12345, uptime 0:00:05
```

### 4. Các lệnh quản lý thường dùng

```bash
# Xem trạng thái
supervisorctl status reverb

# Restart Reverb (sau khi sửa code hoặc .env)
supervisorctl restart reverb

# Stop Reverb
supervisorctl stop reverb

# Xem log real-time
tail -f /var/www/reverb-server/storage/logs/reverb.log
```

---

## D. Nginx reverse proxy (optional nhưng khuyến nghị)

Nginx giúp:
- Che port 8080 đi, chỉ expose 80/443
- Thêm SSL/TLS
- Handle CORS headers đúng cách
- Rate limiting chống abuse

### 1. Tạo subdomain (khuyến nghị)

Trỏ subdomain `reverb.your-domain.com` về VPS IP qua DNS A record.

### 2. Tạo Nginx config

```bash
nano /etc/nginx/sites-available/reverb
```

Nội dung (HTTP only, sẽ add SSL ở bước sau):

```nginx
upstream reverb_backend {
    server 127.0.0.1:8080;
}

server {
    listen 80;
    server_name reverb.your-domain.com;

    # Log
    access_log /var/log/nginx/reverb-access.log;
    error_log /var/log/nginx/reverb-error.log;

    # WebSocket connection upgrade
    location / {
        proxy_pass http://reverb_backend;

        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";

        # Pass real client info
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;

        # WebSocket timeouts (Reverb ping every 60s)
        proxy_read_timeout 300s;
        proxy_send_timeout 300s;
        proxy_connect_timeout 75s;
    }

    # Health check endpoint (no auth needed)
    location = /health {
        proxy_pass http://reverb_backend/health;
        access_log off;
    }

    # Block common abuse paths
    location ~ /\.(?!well-known) {
        deny all;
    }
}
```

### 3. Enable + reload Nginx

```bash
ln -s /etc/nginx/sites-available/reverb /etc/nginx/sites-enabled/
nginx -t
systemctl reload nginx
```

### 4. SSL với Let's Encrypt (khuyến nghị)

```bash
apt install -y certbot python3-certbot-nginx
certbot --nginx -d reverb.your-domain.com
```

Certbot sẽ tự động:
- Lấy cert từ Let's Encrypt
- Sửa Nginx config để redirect HTTP → HTTPS
- Auto-renew mỗi 90 ngày

Sau khi có SSL, đổi `.env` trên VPS:
```env
REVERB_SCHEME=https
APP_URL=https://reverb.your-domain.com
```

Và restart Reverb:
```bash
supervisorctl restart reverb
```

---

## E. Firewall & Security

### 1. UFW rules

```bash
# Default policies
ufw default deny incoming
ufw default allow outgoing

# SSH
ufw allow 22/tcp

# HTTP/HTTPS (cho Nginx reverse proxy)
ufw allow 80/tcp
ufw allow 443/tcp

# Nếu KHÔNG dùng Nginx (expose trực tiếp Reverb port)
# ufw allow from YOUR_CPANEL_IP to any port 8080

# Enable
ufw enable
ufw status verbose
```

### 2. Bảo vệ port 8080 (nếu không dùng Nginx)

Nếu VPS không có Nginx và muốn Reverb chạy trực tiếp trên 8080:

```bash
# Chỉ allow cPanel server IP
ufw allow from YOUR_CPANEL_IP to any port 8080 proto tcp

# Hoặc allow cả dải IP của browser users (không khuyến nghị vì cần cho WebSocket)
```

### 3. Disable root login (khuyến nghị)

```bash
nano /etc/ssh/sshd_config
```
Set `PermitRootLogin no`, tạo user mới với sudo:
```bash
adduser deploy
usermod -aG sudo deploy
```
Reload SSH:
```bash
systemctl reload sshd
```

### 4. Auto security updates

```bash
apt install -y unattended-upgrades
dpkg-reconfigure -plow unattended-upgrades
```

---

## F. Monitoring & Maintenance

### 1. Check Reverb đang chạy

```bash
supervisorctl status reverb
curl -I http://localhost:8080/health
```

### 2. Xem log

```bash
# Reverb log
tail -f /var/www/reverb-server/storage/logs/reverb.log

# Nginx access log (nếu dùng reverse proxy)
tail -f /var/log/nginx/reverb-access.log

# System log
journalctl -u supervisor -f
```

### 3. Monitor resources

```bash
# CPU/RAM của Reverb process
top -p $(pgrep -f "reverb:start")

# Connections count
ss -tan | grep :8080 | wc -l
```

### 4. Rotate logs

Nginx đã có logrotate mặc định. Reverb log rotate qua Supervisor (`stdout_logfile_maxbytes`).

### 5. Backup Supervisor config

```bash
cp /etc/supervisor/conf.d/reverb.conf /backup/
```

---

## Troubleshooting

### Reverb không start được

```bash
# Check error log
tail -50 /var/www/reverb-server/storage/logs/reverb.log

# Test thủ công
cd /var/www/reverb-server
php artisan reverb:start --host=0.0.0.0 --port=8080
```

### Port 8080 đã bị chiếm

```bash
# Tìm process
lsof -i :8080
# Hoặc
ss -tlnp | grep 8080

# Kill process cũ
kill -9 <PID>
```

### Browser không connect được WebSocket

1. Check firewall mở port 8080 (hoặc 443 nếu dùng Nginx + SSL).
2. Test từ browser: mở `https://reverb.your-domain.com/health` → phải trả về `ok`.
3. Check browser console có lỗi CORS không.
4. Verify `REVERB_APP_KEY` giống nhau giữa VPS và cPanel.

### Reverb crash liên tục

```bash
# Xem crash reason
supervisorctl status reverb
journalctl -u supervisor -n 100

# Check OOM (out of memory)
dmesg | grep -i "killed process"
```

Nếu OOM, tăng RAM VPS hoặc tối ưu Reverb:
```ini
# Trong reverb.conf
numprocs=1   # Không tăng nếu RAM thấp
```

---

## Quick Reference

| Task | Command |
|------|---------|
| Start Reverb | `supervisorctl start reverb` |
| Stop Reverb | `supervisorctl stop reverb` |
| Restart Reverb | `supervisorctl restart reverb` |
| Status | `supervisorctl status reverb` |
| Logs | `tail -f /var/www/reverb-server/storage/logs/reverb.log` |
| Health check | `curl http://localhost:8080/health` |
| Edit config | `nano /etc/supervisor/conf.d/reverb.conf` → `supervisorctl reread && supervisorctl update` |

---

**Next step**: Sau khi VPS Reverb chạy ổn định, làm theo `DEPLOYMENT_CHECKLIST.md` để update cPanel app.