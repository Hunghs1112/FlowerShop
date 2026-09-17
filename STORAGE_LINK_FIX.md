# ❌ LỖI 404 KHI TẢI ẢNH LÊN

## 🔍 Nguyên nhân

File ảnh được lưu vào `storage/app/public/categories/` nhưng không truy cập được qua URL `http://lamnhienthao.com/storage/categories/image.jpg`

**Lý do:** Chưa tạo **symbolic link** từ `public/storage` → `storage/app/public`

Laravel lưu file vào `storage/app/public/` nhưng web server chỉ serve được file trong `public_html/` (hoặc `public/`). Symbolic link giúp "kết nối" 2 thư mục này.

---

## ✅ GIẢI PHÁP

### **Cách 1: Chạy script PHP (Khuyến nghị)**

1. Upload file `create-storage-link.php` lên `public_html/`
2. Truy cập: `http://lamnhienthao.com/create-storage-link.php`
3. Nếu thấy `✅ SUCCESS!` = xong
4. Test lại upload ảnh

### **Cách 2: Dùng cPanel Terminal**

Nếu hosting có SSH/Terminal:

```bash
cd public_html
php artisan storage:link
```

### **Cách 3: Tạo symlink bằng cPanel File Manager**

1. cPanel → **File Manager**
2. Vào thư mục `public_html/`
3. Tìm thư mục `storage/app/public/`
4. **Right-click** → **Create Link**
5. Link Name: `storage` (đặt link này trong `public_html/`)
6. Save

### **Cách 4: Manual - tạo thư mục categories**

Nếu không thể tạo symlink (hosting cấm):

1. Tạo thư mục: `public_html/storage/categories/`
2. Di chuyển file ảnh từ `storage/app/public/categories/` sang `public_html/storage/categories/`
3. Sửa code để lưu trực tiếp vào `public/storage/` thay vì `storage/app/public/`

---

## 🎯 Sau khi tạo symlink

File structure sẽ như này:

```
public_html/
├── storage/          ← SYMBOLIC LINK (trỏ đến storage/app/public/)
│   ├── categories/   
│   │   └── 1789632731-MUojk9fN.jpg  ← Truy cập được!
│   └── products/
├── storage/          ← THƯ MỤC GỐC
│   └── app/
│       └── public/
│           ├── categories/
│           │   └── 1789632731-MUojk9fN.jpg  ← File thật ở đây
│           └── products/
```

URL: `http://lamnhienthao.com/storage/categories/1789632731-MUojk9fN.jpg` sẽ hoạt động!

---

## 📝 Lưu ý

- Đã tạo folder `storage/app/public/categories/` trong local
- Upload folder `storage/` lên server khi deploy
- Chỉ cần tạo symlink 1 lần duy nhất
- Sau khi tạo xong, **XÓA** file `create-storage-link.php` để bảo mật

---

Thử Cách 1 trước (chạy script), nếu không được báo tôi nhé!
