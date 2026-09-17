# Hướng Dẫn Kiểm Tra Hệ Thống Chat Real-time

## 1. Yêu Cầu Trước Khi Bắt Đầu

### 1.1 Pusher Credentials
Kiểm tra file `.env` có chứa Pusher credentials:
```env
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-pusher-key
PUSHER_APP_SECRET=your-pusher-secret
PUSHER_APP_CLUSTER=ap1
```

> **Lưu ý:** Nếu chưa có Pusher credentials:
> 1. Đăng ký tài khoản miễn phí tại [pusher.com](https://pusher.com)
> 2. Tạo app mới, chọn cluster `ap1` (Singapore - gần Việt Nam)
> 3. Copy credentials vào file `.env`

### 1.2 Cài Đặt Dependencies
```bash
composer install
npm install
php artisan migrate
```

## 2. Các Bước Khởi Động

### 2.1 Khởi Động Server
```bash
php artisan serve
```
Mở trình duyệt tại: `http://127.0.0.1:8000`

### 2.2 Xóa Cache (Nếu Cần)
```bash
php artisan config:clear
php artisan view:clear
php artisan cache:clear
```

## 3. Kịch Bản Kiểm Tra

### 3.1 Kịch Bản 1: Khách Hàng Gửi Tin Nhắn Cho Admin

**Bước 1:** Đăng nhập với tài khoản khách hàng
- Truy cập `http://127.0.0.1:8000/login`
- Đăng nhập với email/password đã đăng ký

**Bước 2:** Mở trang Chat
- Click vào avatar/username ở góc phải navbar
- Chọn "Chat" từ dropdown menu

**Bước 3:** Gửi tin nhắn
- Nhập tin nhắn: "Xin chào, tôi cần hỗ trợ về đơn hàng"
- Nhấn Enter hoặc click nút Gửi

**Kết quả mong đợi:**
- Tin nhắn hiển thị ở phía bên phải (màu xanh lá)
- Thời gian gửi hiển thị bên dưới tin nhắn
- Tin nhắn được lưu vào database

### 3.2 Kịch Bản 2: Admin Trả Lời Tin Nhắn

**Bước 1:** Đăng nhập với tài khoản Admin
- Truy cập `http://127.0.0.1:8000/login`
- Đăng nhập với email/password có `is_admin = true`

**Bước 2:** Mở Dashboard Admin
- Truy cập `http://127.0.0.1:8000/admin`

**Bước 3:** Mở Chat Dashboard
- Click "Chat" trong sidebar bên trái
- Hoặc truy cập trực tiếp: `http://127.0.0.1:8000/admin/chats`

**Bước 4:** Chọn khách hàng
- Danh sách khách hàng hiển thị ở cột bên trái
- Khách hàng có tin nhắn chưa đọc sẽ có badge màu đỏ

**Bước 5:** Trả lời tin nhắn
- Click vào tên khách hàng
- Nhập tin nhắn: "Xin chào, chúng tôi sẽ hỗ trợ bạn ngay"
- Nhấn Enter hoặc click nút Gửi

**Kết quả mong đợi:**
- Tin nhắn admin hiển thị ở phía bên trái (màu xám)
- Tin nhắn được broadcast real-time đến khách hàng
- Badge unread trên sidebar giảm đi 1

### 3.3 Kịch Bản 3: Real-time Updates

**Bước 1:** Mở 2 cửa sổ trình duyệt
- Cửa sổ A: Đăng nhập với tài khoản khách hàng
- Cửa sổ B: Đăng nhập với tài khoản Admin

**Bước 2:** Kiểm tra real-time
- Ở Cửa sổ A: Gửi tin nhắn "Tôi muốn hỏi về sản phẩm hoa hồng"
- **Không cần refresh trang**
- Kiểm tra Cửa sổ B: Tin nhắn xuất hiện ngay lập tức

**Bước 3:** Kiểm tra admin reply
- Ở Cửa sổ B: Admin trả lời "Hoa hồng của chúng tôi đang có giá..."
- **Không cần refresh trang**
- Kiểm tra Cửa sổ A: Tin nhắn xuất hiện ngay lập tức

**Kết quả mong đợi:**
- Tin nhắn xuất hiện tức thì không cần reload trang
- Không có hiện tượng lag hoặc delay > 3 giây

### 3.4 Kịch Bản 4: Kiểm Tra Unread Badge

**Bước 1:** Kiểm tra badge trên navbar (khách hàng)
- Đăng nhập với tài khoản khách hàng
- Kiểm tra menu dropdown có hiển thị số unread không

**Bước 2:** Kiểm tra badge trên admin sidebar
- Đăng nhập với tài khoản admin
- Kiểm tra sidebar có hiển thị tổng số unread từ tất cả khách hàng không

**Kết quả mong đợi:**
- Badge hiển thị số chính xác
- Badge biến mất khi đã đọc hết tin nhắn

## 4. Xử Lý Sự Cố

### 4.1 Lỗi: "Pusher connection failed"

**Nguyên nhân:** Pusher credentials không đúng hoặc chưa cấu hình

**Cách khắc phục:**
1. Kiểm tra file `.env` có đúng format:
```env
PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-pusher-key
PUSHER_APP_SECRET=your-pusher-secret
PUSHER_APP_CLUSTER=ap1
```

2. Clear cache:
```bash
php artisan config:clear
php artisan cache:clear
```

3. Kiểm tra Pusher Dashboard:
   - Truy cập [pusher.com](https://pusher.com)
   - Vào App Dashboard > Settings
   - Verify credentials khớp với file `.env`

### 4.2 Lỗi: "Channel authorization failed"

**Nguyên nhân:** CSRF token hoặc authentication có vấn đề

**Cách khắc phục:**
1. Đảm bảo đã đăng nhập (authentication required)
2. Kiểm tra `routes/channels.php` có đúng:
```php
Broadcast::channel('chat.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId || $user->isAdmin();
});
```

3. Kiểm tra Browser Console (F12 > Console):
   - Tìm lỗi liên quan đến Pusher hoặc Echo

### 4.3 Lỗi: Tin nhắn không hiển thị real-time

**Nguyên nhân:** Broadcasting không hoạt động

**Cách khắc phục:**
1. Kiểm tra Broadcasting config:
```bash
php artisan config:clear
php artisan config:cache
```

2. Kiểm tra `config/broadcasting.php` có tồn tại không

3. Verify Pusher JS được load đúng cách:
   - Mở trang Chat
   - F12 > Network tab
   - Tìm `pusher.min.js` có status 200

### 4.4 Lỗi: "Class ChatMessage not found"

**Nguyên nhân:** Migration chưa chạy

**Cách khắc phục:**
```bash
php artisan migrate
php artisan db:seed --class=DatabaseSeeder  # Nếu cần
```

### 4.5 Lỗi: Database Exception - Table not found

**Nguyên nhân:** Bảng `chat_messages` chưa được tạo

**Cách khắc phục:**
1. Kiểm tra migration đã tồn tại:
```bash
php artisan migrate:status | grep chat_messages
```

2. Chạy migration:
```bash
php artisan migrate
```

### 4.6 Lỗi: Styles không hiển thị đúng

**Nguyên nhêm:** CSS chưa được build lại

**Cách khắc phục:**
```bash
.\build-css.ps1
php artisan view:clear
```

## 5. Kiểm Tra Nhanh (Quick Check)

Chạy các lệnh sau để verify hệ thống hoạt động:

```bash
# 1. Verify routes
php artisan route:list --path=chat

# 2. Verify migration
php artisan migrate:status

# 3. Verify views
php artisan view:clear && php artisan view:cache

# 4. Verify CSS
grep -n "\.chat-page" public/css/app.css
grep -n "\.admin-chat-layout" public/css/app.css
```

## 6. Browser Console Checklist

Mở Developer Tools (F12) > Console tab và kiểm tra:

- [ ] Không có lỗi `Pusher` hoặc `Echo`
- [ ] Không có lỗi `401 Unauthorized`
- [ ] Không có lỗi `500 Internal Server Error`

### Kiểm tra Pusher Connection:
```javascript
// Mở Console, gõ:
Echo.connector.pusher.connection.state
// Kết quả: "connected" nghĩa là OK
```

### Kiểm tra Channel Subscription:
```javascript
// Mở Console, gõ:
Echo.connector.pusher.channels.channels
// Sẽ hiển thị các channels đã subscribe
```

## 7. Cấu Trúc File Quan Trọng

```
resources/views/
├── chat/
│   └── index.blade.php          # Customer chat UI
├── admin/
│   └── chats/
│       ├── index.blade.php      # Admin chat list
│       └── show.blade.php       # Admin chat detail
└── partials/
    └── navbar.blade.php         # Chat link in dropdown

app/
├── Http/Controllers/
│   ├── ChatController.php       # Customer chat logic
│   └── Admin/ChatController.php # Admin chat logic
└── Models/
    └── ChatMessage.php          # Message model

database/migrations/
└── 2026_09_16_151400_create_chat_messages_table.php

public/css/
├── chat.css                     # Customer chat styles
└── admin/chat.css               # Admin chat styles
```

## 8. Liên Hệ Hỗ Trợ

Nếu gặp lỗi không nằm trong danh sách trên:
1. Chụp ảnh lỗi (Console + Network tab)
2. Liệt kê các bước đã thực hiện
3. Gửi thông tin qua email/hệ thống hỗ trợ
