# Deployment Checklist — Reverb Hybrid Setup

Checklist triển khai Reverb WebSocket trên VPS riêng + Laravel app trên cPanel hosting.

---

## Phase 1: VPS Setup (chạy trên VPS)

### Cài đặt cơ bản
- [ ] SSH vào VPS thành công
- [ ] `apt update && apt upgrade` chạy xong
- [ ] PHP 8.2+ cài đặt (`php -v` kiểm tra)
- [ ] Composer cài đặt (`composer --version`)
- [ ] Supervisor + Nginx + UFW cài đặt

### Cài đặt Reverb
- [ ] Project folder `/var/www/reverb-server` đã tạo
- [ ] Code Laravel đã deploy lên (git clone hoặc composer create-project)
- [ ] File `.env` đã cấu hình đầy đủ
- [ ] `php artisan key:generate` đã chạy
- [ ] `REVERB_APP_ID` đã generate (random string)
- [ ] `REVERB_APP_KEY` đã generate
- [ ] `REVERB_APP_SECRET` đã generate
- [ ] `REVERB_HOST=0.0.0.0` set đúng
- [ ] `REVERB_PORT=8080` set đúng
- [ ] **LƯU LẠI 3 giá trị APP_ID/KEY/SECRET** (sẽ copy sang cPanel)
- [ ] Test `php artisan reverb:start` chạy được (foreground)
- [ ] Test `curl http://localhost:8080/health` trả về `ok`

### Supervisor
- [ ] File `/etc/supervisor/conf.d/reverb.conf` đã tạo
- [ ] `supervisorctl reread` chạy OK
- [ ] `supervisorctl update` chạy OK
- [ ] `supervisorctl start reverb` chạy OK
- [ ] `supervisorctl status reverb` → `RUNNING`
- [ ] Test restart: `supervisorctl restart reverb` → vẫn RUNNING
- [ ] Log file `/var/www/reverb-server/storage/logs/reverb.log` đang ghi
- [ ] Phân quyền: `chown -R www-data:www-data storage`

### Nginx reverse proxy (optional)
- [ ] Subdomain `reverb.your-domain.com` đã trỏ về VPS IP (DNS A record)
- [ ] File `/etc/nginx/sites-available/reverb` đã tạo
- [ ] Symlink tới `sites-enabled` đã tạo
- [ ] `nginx -t` không có lỗi
- [ ] `systemctl reload nginx` chạy OK
- [ ] Test `http://reverb.your-domain.com/health` trả về `ok`
- [ ] SSL cert Let's Encrypt đã cài (`certbot --nginx`)
- [ ] Test `https://reverb.your-domain.com/health` trả về `ok`
- [ ] Nếu có SSL, `REVERB_SCHEME=https` trong `.env`

### Firewall
- [ ] UFW enabled
- [ ] Port 22 (SSH) allowed
- [ ] Port 80 (HTTP) allowed
- [ ] Port 443 (HTTPS) allowed
- [ ] Nếu không dùng Nginx: port 8080 chỉ allow từ cPanel IP
- [ ] `ufw status verbose` kiểm tra rules

### Security hardening
- [ ] Root login disabled (`PermitRootLogin no`)
- [ ] User deploy với sudo đã tạo
- [ ] Unattended-upgrades enabled

---

## Phase 2: cPanel App Config (chạy trên cPanel hoặc local)

### .env updates
- [ ] Mở file `.env` trên cPanel (qua File Manager hoặc FTP)
- [ ] Set `BROADCAST_CONNECTION=reverb`
- [ ] Set `REVERB_HOST=reverb.your-domain.com` (hoặc VPS IP)
- [ ] Set `REVERB_PORT=8080` (hoặc 443 nếu dùng Nginx + SSL)
- [ ] Set `REVERB_SCHEME=https` (nếu có SSL, ngược lại `http`)
- [ ] Set `REVERB_APP_ID=<giá trị giống VPS>`
- [ ] Set `REVERB_APP_KEY=<giá trị giống VPS>`
- [ ] Set `REVERB_APP_SECRET=<giá trị giống VPS>`
- [ ] Xóa Pusher config cũ:
  - [ ] Remove `PUSHER_APP_KEY`
  - [ ] Remove `PUSHER_APP_SECRET`
  - [ ] Remove `PUSHER_APP_CLUSTER`
- [ ] Save file `.env`
- [ ] Clear config cache: `php artisan config:clear`

### Composer
- [ ] SSH vào cPanel (nếu có) hoặc dùng Terminal của cPanel
- [ ] `cd ~/public_html` (hoặc path app)
- [ ] `composer remove pusher/pusher-php-server` (nếu có)
- [ ] `composer require laravel/reverb`
- [ ] Verify file `config/broadcasting.php` có section `'reverb'`
- [ ] `php artisan config:cache`

### Views update
- [ ] `resources/views/chat/index.blade.php` đã update Echo config (Reverb)
- [ ] `resources/views/admin/chats/show.blade.php` đã update Echo config (Reverb)
- [ ] Thay CDN: `pusher.min.js` → không cần (Reverb dùng native WebSocket)
- [ ] Verify không còn reference đến `Echo.connector.pusher`
- [ ] Test load trang `/chat` không có JS error

### Broadcasting auth
- [ ] `routes/channels.php` đã định nghĩa channel `chat.{userId}`
- [ ] Auth callback check user đúng chủ sở hữu channel
- [ ] `broadcasting/auth` route hoạt động (test bằng curl với session)

---

## Phase 3: Testing & Verification

### Test VPS Reverb độc lập
- [ ] SSH vào VPS
- [ ] `curl http://localhost:8080/health` → `ok`
- [ ] Nếu có Nginx: `curl https://reverb.your-domain.com/health` → `ok`
- [ ] `supervisorctl status reverb` → RUNNING
- [ ] Tail log: `tail -f storage/logs/reverb.log` thấy connections mới khi test

### Test cPanel → VPS connection (broadcast side)
- [ ] Login vào cPanel app với user A
- [ ] Mở `/chat` page
- [ ] Gửi 1 message
- [ ] Kiểm tra VPS log có event broadcast không:
  ```bash
  tail -f /var/www/reverb-server/storage/logs/reverb.log
  ```
- [ ] Log phải show connection từ cPanel IP

### Test end-to-end real-time chat
- [ ] Mở browser A (user role) → `/chat`
- [ ] Mở browser B (admin role) → `/admin/chats/{userId}`
- [ ] Verify cả 2 browser hiển thị "Đã kết nối" (status connected)
- [ ] User A gửi message "Test 1"
- [ ] **Browser B nhận được message ngay lập tức** (không cần refresh)
- [ ] User B (admin) reply "Reply 1"
- [ ] **Browser A nhận được reply ngay lập tức**
- [ ] Test với 3+ browser cùng lúc
- [ ] Đóng 1 browser, mở lại → auto-reconnect thành công

### Browser console checks
- [ ] User browser: console KHÔNG có lỗi WebSocket
- [ ] User browser: console KHÔNG có lỗi CORS
- [ ] Admin browser: console KHÔNG có lỗi WebSocket
- [ ] Admin browser: console KHÔNG có lỗi CORS
- [ ] Network tab thấy WebSocket connection `wss://reverb.your-domain.com/app/...` status 101

### Stress test (optional)
- [ ] Mở 5+ browser tabs cùng subscribe
- [ ] Gửi 10+ messages liên tục
- [ ] Verify VPS không crash, CPU/RAM ổn định
- [ ] `supervisorctl status reverb` vẫn RUNNING

---

## Phase 4: Production Hardening

### Monitoring
- [ ] Setup cron check Reverb mỗi 5 phút, alert nếu down
- [ ] Script monitor: `/usr/local/bin/check-reverb.sh`:
  ```bash
  #!/bin/bash
  if ! curl -sf http://localhost:8080/health > /dev/null; then
      supervisorctl restart reverb
      echo "Reverb restarted at $(date)" | mail -s "Reverb Alert" you@email.com
  fi
  ```
- [ ] Add vào cron: `*/5 * * * * /usr/local/bin/check-reverb.sh`
- [ ] (Optional) Cài node_exporter + Prometheus + Grafana để monitor chi tiết

### Backup
- [ ] Backup `/etc/supervisor/conf.d/reverb.conf`
- [ ] Backup `/var/www/reverb-server/.env` (không commit lên git!)
- [ ] Backup Nginx config `/etc/nginx/sites-available/reverb`
- [ ] Document VPS credentials ở password manager (KHÔNG trong repo)
- [ ] (Optional) Snapshot VPS image hàng tuần

### Logging
- [ ] Nginx access log đang rotate (`/etc/logrotate.d/nginx`)
- [ ] Reverb log đang rotate (qua Supervisor `stdout_logfile_maxbytes`)
- [ ] Centralized logging nếu có (Papertrail, Loggly, etc.)

### Documentation
- [ ] Team biết cách restart Reverb (`supervisorctl restart reverb`)
- [ ] Team biết cách xem log
- [ ] Emergency contact list cho VPS provider
- [ ] On-call rotation (nếu production critical)

---

## Phase 5: Rollback Plan

Nếu có sự cố, rollback theo thứ tự:

1. **cPanel .env** → đổi `BROADCAST_CONNECTION=pusher` (hoặc `log`)
2. **Views** → revert Blade files về version cũ (dùng Pusher CDN)
3. **VPS** → `supervisorctl stop reverb` (không cần xóa, chỉ stop)
4. Verify app vẫn hoạt động bình thường (chat sẽ chỉ dùng polling/AJAX, không real-time)

### Auto-rollback triggers
- VPS down > 5 phút → cPanel tự fallback về log driver
- Reverb crash liên tục (> 5 lần/giờ) → check resource usage

---

## Quick Reference — Common Commands

### Trên VPS
```bash
supervisorctl status reverb          # Check status
supervisorctl restart reverb         # Restart
tail -f /var/www/reverb-server/storage/logs/reverb.log   # Live log
curl http://localhost:8080/health    # Health check
```

### Trên cPanel
```bash
cd ~/public_html
php artisan config:clear             # Clear config cache
php artisan cache:clear              # Clear app cache
php artisan route:clear              # Clear route cache
```

### Test broadcast từ cPanel (Tinker)
```bash
php artisan tinker
>>> event(new \App\Events\MessageSent($message));
```

---

## Sign-off

Sau khi hoàn thành tất cả checklist:

- [ ] Date deployed: _______________
- [ ] Deployed by: _______________
- [ ] VPS IP/Domain: _______________
- [ ] cPanel domain: _______________
- [ ] Test user account: _______________
- [ ] Test admin account: _______________
- [ ] Status: ☐ Production-ready ☐ Needs fixes

**Ghi chú**: _______________________________

---

## Support

Nếu gặp vấn đề không có trong checklist:
1. Check `REVERB_VPS_SETUP.md` → section Troubleshooting
2. Xem Reverb official docs: https://laravel.com/docs/11.x/reverb
3. Check Laravel Discord: https://discord.gg/laravel