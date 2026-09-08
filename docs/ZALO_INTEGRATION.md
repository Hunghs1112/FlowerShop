# Tích hợp Zalo OA - Hướng dẫn chi tiết

## Mục lục
1. [Giới thiệu](#giới-thiệu)
2. [Đăng ký và cấu hình Zalo OA](#đăng-ký-và-cấu-hình-zalo-oa)
3. [Cấu hình dự án](#cấu-hình-dự-án)
4. [Lấy Access Token](#lấy-access-token)
5. [Kiểm tra và sử dụng](#kiểm-tra-và-sử-dụng)
6. [Xử lý lỗi thường gặp](#xử-lý-lỗi-thường-gặp)

---

## Giới thiệu

Tích hợp Zalo OA (Official Account) cho phép shop hoa gửi thông báo đơn hàng tự động cho admin và khách hàng qua Zalo.

### Tính năng
- ✅ Thông báo đơn hàng mới cho admin
- ✅ Gửi xác nhận đơn hàng cho khách hàng
- ✅ Hỗ trợ cả đơn hàng thường và đặt hàng nhanh
- ✅ Tự động refresh access token

---

## Đăng ký và cấu hình Zalo OA

### Bước 1: Tạo Zalo Official Account

1. Truy cập: https://oa.zalo.me/
2. Đăng nhập bằng tài khoản Zalo của bạn
3. Nhấn **"Tạo Official Account"**
4. Chọn loại tài khoản: **Doanh nghiệp/Tổ chức**
5. Điền thông tin:
   - Tên Official Account: "Lâm Nhiên Thảo"
   - Lĩnh vực: Bán lẻ / Hoa và Quà tặng
   - Mô tả: Thông tin về shop hoa
6. Upload avatar và ảnh bìa
7. Hoàn tất đăng ký

### Bước 2: Xác thực Official Account

1. Chờ Zalo xét duyệt (thường 1-3 ngày làm việc)
2. Chuẩn bị giấy tờ:
   - CMND/CCCD chủ shop
   - Giấy phép kinh doanh (nếu có)
   - Ảnh mặt tiền cửa hàng

### Bước 3: Lấy thông tin OA

1. Vào **Quản lý Official Account**: https://oa.zalo.me/home
2. Chọn OA vừa tạo
3. Vào **Cài đặt** → **Thông tin cơ bản**
4. Lưu lại **OA ID** (ví dụ: 1234567890123456789)

### Bước 4: Tạo ứng dụng Zalo

1. Truy cập: https://developers.zalo.me/
2. Đăng nhập bằng tài khoản đã tạo OA
