# Ghi chú rà soát website

## Phần 1 — Nội dung trang chủ và trang giới thiệu

### Trang chủ

- **Các chuyến hoa hôm nay:** danh sách lấy tối đa 4 sản phẩm mới về qua `HomeController` và `ProductService`. Trạng thái được suy ra từ ngày đến dự kiến của sản phẩm; khi không có sản phẩm sẽ dùng dữ liệu mẫu trong JavaScript.
- **Hàng mới hạ cánh:** dùng danh sách sản phẩm backend; ảnh, tên, xuất xứ và liên kết sản phẩm được đưa vào giao diện bằng component `product-card`.
- **WINDOW SEAT / Những nơi tuyệt đẹp:** ảnh và nhãn lấy từ bảng `gallery_images`; có màn hình admin để quản lý ảnh, tiêu đề, chú thích, thứ tự và trạng thái.
- **Admin:** có quản lý banner trang chủ; gallery WINDOW SEAT được bổ sung mục quản lý riêng.

### Trang giới thiệu (`/gioi-thieu`)

- **Chín vùng đất, một điểm đến:** bản đồ và danh sách điểm đến lấy từ `FlowerOrigin` trong database. Admin nguồn gốc hoa quản lý mã quốc gia và tọa độ phục vụ bản đồ.
- **Hộ chiếu hoa:** giao diện gọi API có xác thực, lấy dấu từ sản phẩm trong đơn hàng đã hoàn tất và ánh xạ nguồn gốc qua `FlowerOrigin`. Chế độ mẫu vẫn có thể xem qua nút demo.
- **Admin nguồn gốc hoa:** đã bổ sung trường mã quốc gia và tọa độ; migration bổ sung các trường và dữ liệu cần cho bản đồ.

### Đã triển khai

1. Gallery WINDOW SEAT có dữ liệu backend và giao diện quản trị.
2. Bản đồ vùng hoa dùng dữ liệu `FlowerOrigin` và tọa độ do admin quản lý.
3. Hộ chiếu hoa lấy dấu từ đơn đã hoàn tất qua API xác thực.
4. **Thẻ sản phẩm dùng chung:** component `product-card` hỗ trợ nhãn tuyến bay (ví dụ `UIO → HAN`) và nhãn trạng thái; trang chủ dùng component chung thay markup thẻ riêng.

### Lưu ý vận hành

- Cần chạy migration mới khi triển khai để tạo `gallery_images` và bổ sung trường tọa độ/mã quốc gia cho `flower_origins`.
- Hộ chiếu chỉ nhận dấu khi nguồn gốc sản phẩm khớp dữ liệu `FlowerOrigin`; rà soát tên nguồn gốc thực tế trong catalog nếu khách hàng thiếu dấu.
