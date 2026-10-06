# Mục "Mùa lễ hội" – hướng dẫn sửa nội dung

File: `mua-le-hoi.html` (gồm trang tổng + Hội mùa thu `#thu` + Halloween `#halloween` + Cây thông Đan Mạch `#thong`).

## Cách 1 – Tự điền bằng biểu mẫu (không cần biết code) ✅
1. Tải file `mua-le-hoi.html` (hoặc `phu-kien-cay-thong.html`) về máy, **mở bằng trình duyệt** (Chrome, Edge…).
2. Bấm nút **✎ Sửa nội dung** ở góc dưới bên phải.
3. Chọn thẻ: **Chung** · **Hội mùa thu** · **Halloween** · **Cây thông Đan Mạch**.
4. Gõ vào các ô – trang bên cạnh cập nhật ngay. Mỗi danh sách (cỡ cây, phụ kiện, sản phẩm, câu hỏi…) có nút
   **+ Thêm**, **✕ Xoá**, **↑ ↓** để đổi thứ tự. Ảnh: dán link ảnh trên web, hoặc bấm **Chọn ảnh từ máy**.
5. Xong bấm **⬇ Tải file đã sửa** → được file HTML mới, gửi người làm web đưa lên (hoặc tự tải lên nếu có quyền).

Nút **✎ Sửa nội dung** chỉ hiện khi mở file trên máy, hoặc khi thêm `?sua` vào cuối đường dẫn
(ví dụ `lamnhienthao.com/mua-le-hoi?sua`). Khách bình thường không thấy nút này.

## Cách 2 – Sửa trực tiếp trong code
Mở file bằng Notepad / VS Code, tìm dòng **`const CONFIG = {`** (gần đầu phần nội dung). Mọi chữ, ngày, giá, sản phẩm đều nằm trong khối này.
Chỉ sửa chữ **bên trong dấu nháy** `'...'`, giữ nguyên dấu phẩy và ngoặc.

| Muốn đổi | Sửa ở |
|---|---|
| Tiêu đề, câu giới thiệu trang tổng | `hub` |
| Tên dịp, câu khẩu hiệu, trạng thái, ngày | `name`, `tagline`, `status`, `date` của từng dịp |
| Trạng thái trên bảng | `'Đang bay'` · `'Mở đặt trước'` · `'Sắp cất cánh'` · `'Đã hạ cánh'` |
| Ảnh lớn | `img` (link ảnh trên web, ví dụ `'/uploads/thong.jpg'`) |
| Sản phẩm | `products`: tên, xuất xứ, mã sân bay, ảnh, link, nhãn |
| Bảng màu mùa thu | `palette`: `['Tên màu', '#mã màu']` |
| Lá bài Trick / Treat | `trickTreat` |
| Cây thông: hạn đặt, ngày về, cọc | `tree.deadline`, `tree.arrival`, `tree.deposit` |
| Cỡ cây & giá | `tree.sizes`: `{ label: '1,8 m', cm: 180, price: '1.500.000đ' }` (để `price: ''` → hiện "Liên hệ báo giá") |
| Dịch vụ đi kèm (giao & dựng, trang trí, thu gom) | `tree.addons` |
| Bộ trang trí trọn gói | `tree.packages.items`: tên, mô tả, 3 mã màu, giá, ảnh |
| Phụ kiện & đồ trang trí lẻ | `tree.accessories`: chia nhóm, mỗi món có tên, mô tả, icon, giá, ảnh |
| Câu hỏi thường gặp | `tree.faq` |
| Thẻ chăm cây | `tree.care`: `['Nhãn', 'Nội dung']` |

- **Thêm / bớt một dịp** (ví dụ Tết): chép nguyên một khối `{ id: ..., ... },` trong `seasons` và sửa. `theme` chọn `'autumn'`, `'night'` hoặc `'nordic'`.
- Ngày dạng `'2026-10-31'`. Đồng hồ đếm ngược tự tính.
- **Phụ kiện**: thêm món = chép một dòng `{ name: ..., price: '', img: '' },` trong nhóm; thêm nhóm = chép cả khối `{ group: ..., items: [ ... ] },`.
  Có ảnh thật thì điền `img: '/uploads/qua-chau.jpg'`; để trống thì hiện hình vẽ theo `icon`.
  Giá ghi dạng `'150.000đ'` → phiếu đặt tự cộng **tạm tính**; để `''` → hiện "Liên hệ báo giá".

## Nhận đơn đặt trước cây thông
- `orderEndpoint: ''` → khách bấm Gửi sẽ nhận phiếu tóm tắt để **sao chép và gửi qua Zalo**.
- Muốn đơn tự về Google Sheet (giống form B2B): dán link Google Apps Script vào `orderEndpoint`.
  Dữ liệu gửi đi gồm: kichthuoc, phukien, tuychon, hoten, sdt, diachi, ngaynhan, ghichu, thoigian.

## Sửa trong trang admin (cho người làm web)
Có thể chuyển khối `CONFIG` thành một file riêng `mua-le-hoi-config.js` hoặc một ô "mã tuỳ chỉnh" trong admin;
trang sẽ đọc nội dung từ đó mà không cần sửa phần còn lại.
