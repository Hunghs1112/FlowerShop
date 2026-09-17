## 🔧 HƯỚNG DẪN BẬT FILEINFO CHO LITESPEED

Server của bạn đang dùng **LiteSpeed**, không phải Apache thuần, nên cần cách khác.

### ✅ GIẢI PHÁP DUY NHẤT: Bật trong cPanel

**Vì sao php.ini không hoạt động?**
- LiteSpeed dùng cơ chế riêng để load extensions
- File php.ini/user.ini có thể bị ignore
- fileinfo có trong phpinfo() = hosting đã cài đặt, chỉ cần BẬT

### 📋 CÁC BƯỚC BẬT TRONG CPANEL

#### **Bước 1: Select PHP Version**
```
cPanel → Software → Select PHP Version
```

#### **Bước 2: Vào tab Extensions**
```
Click tab "Extensions" (phía trên)
```

#### **Bước 3: Tìm và bật fileinfo**
```
Scroll xuống tìm: fileinfo
Click checkbox bên cạnh để BẬT
```

#### **Bước 4: Save**
```
Click nút "Save" hoặc "Apply"
```

#### **Bước 5: Đợi 30 giây**
```
LiteSpeed cần thời gian reload config
```

#### **Bước 6: Test lại**
```
Truy cập: http://lamnhienthao.com/check-fileinfo.php
Phải thấy: ✅ fileinfo extension: LOADED
```

---

### 🎯 NẾU KHÔNG TÌM THẤY TAB EXTENSIONS

Một số cPanel ẩn tab Extensions, thử cách khác:

#### **Cách 2: MultiPHP INI Editor**
```
cPanel → Software → MultiPHP INI Editor
→ Chọn domain: lamnhienthao.com
→ Tìm dòng: fileinfo
→ Đổi thành: On
→ Save Changes
```

#### **Cách 3: PHP ini Editor**
```
cPanel → Software → PHP ini Editor
→ Mode: Advanced
→ Tìm: extension
→ Thêm dòng: extension=fileinfo.so
→ Save
```

---

### 📞 NẾU VẪN KHÔNG TÌM THẤY

Gửi ticket cho hosting support:

```
Subject: Enable fileinfo extension for PHP 8.2

Xin chào,

Domain: lamnhienthao.com
PHP Version: 8.2.33
Server: LiteSpeed

Extension "fileinfo" đã có trong phpinfo() nhưng chưa được enable.
Xin hỗ trợ enable extension này qua cPanel Select PHP Version.

Cảm ơn!
```

---

### ⚠️ LƯU Ý

- **KHÔNG CẦN** upload php.ini hay .user.ini (LiteSpeed có thể ignore)
- **BẮT BUỘC** phải bật qua cPanel UI
- Sau khi bật, đợi 30-60 giây để LiteSpeed reload

---

Hãy thử bật trong cPanel và báo kết quả!
