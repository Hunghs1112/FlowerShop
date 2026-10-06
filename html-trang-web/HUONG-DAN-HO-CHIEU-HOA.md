# Hộ chiếu hoa – hướng dẫn nối dữ liệu (cho người làm web)

Trang `ve-chung-toi.html` hiển thị cuốn **Hộ chiếu hoa** của khách đang đăng nhập.
Mỗi con dấu tương ứng một quốc gia; khách chỉ có dấu khi đã **mua hoa của nước đó**.

## 1. Gắn xuất xứ cho sản phẩm
Mỗi sản phẩm hoa cần một thuộc tính/tag "xuất xứ" với một trong các mã:

| Mã | Quốc gia | Dấu |
|----|----------|-----|
| `cn` | Trung Quốc | KMG |
| `nl` | Hà Lan | AMS |
| `ec` | Ecuador | UIO |
| `za` | Nam Phi | CPT |
| `jp` | Nhật Bản | CTS |
| `my` | Malaysia | KUL |
| `vn` | Việt Nam | DLI |
| `co` | Colombia | BOG |
| `nz` | New Zealand | CHC |

## 2. Ghi con dấu khi đơn hoàn tất
Khi đơn hàng chuyển sang trạng thái **đã thanh toán và giao thành công**, với mỗi mã xuất xứ có trong đơn,
nếu khách chưa có dấu nước đó thì lưu một bản ghi: `{country, date, order}` vào tài khoản khách.
Đơn bị huỷ/hoàn tiền thì không đóng dấu (hoặc thu hồi dấu nếu đã đóng).

## 3. Đưa dữ liệu vào trang (chọn MỘT cách)
**Cách A – in sẵn vào trang** (đặt trước script của trang):
```html
<script>
window.LNT_PASSPORT = {
  loggedIn: true,
  name: "Minh Anh",
  stamps: [
    { "country": "ec", "date": "2026-09-12", "order": "#LNT1042" },
    { "country": "nz", "date": "2026-10-01", "order": "#LNT1188" }
  ]
};
</script>
```
Khách chưa đăng nhập: `window.LNT_PASSPORT = { loggedIn: false, stamps: [] };`

**Cách B – API**: đặt `PASSPORT_CONFIG.api = "/api/ho-chieu-hoa"` trong file HTML.
API trả về JSON cùng định dạng trên, dựa theo phiên đăng nhập (cookie).

## 4. Cấu hình trong file HTML (`PASSPORT_CONFIG`)
- `loginUrl`, `registerUrl`: đường dẫn trang đăng nhập / đăng ký.
- `category`: đường dẫn danh mục hoa của từng nước (nút "Xem hoa … →").
- `reward`, `rewardLink`: nội dung và đường dẫn phần thưởng khi đủ 9 dấu.
- `demo`: **đặt `false` khi đưa lên web thật** (tắt dữ liệu mẫu và các nút "Xem bản mẫu").

## 5. Phần thưởng
Việc cộng điểm thành viên / trao thưởng khi đủ 9 dấu nên được xử lý ở hệ thống (máy chủ),
không dựa vào trang HTML, để tránh gian lận.
