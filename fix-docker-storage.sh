#!/bin/bash
# Script tự động sửa lỗi 403 Storage trong Docker container

echo "=== Sửa lỗi Storage 403 trong Docker ==="
echo ""

CONTAINER_NAME="flowershop-app"

# Kiểm tra container có đang chạy không
if ! docker ps | grep -q "$CONTAINER_NAME"; then
    echo "❌ Container $CONTAINER_NAME không chạy!"
    exit 1
fi

echo "✓ Container đang chạy"

# Xóa symlink cũ (sai đường dẫn)
echo "→ Xóa symlink cũ..."
docker exec $CONTAINER_NAME rm -f /var/www/html/public/storage

# Tạo symlink mới (đúng đường dẫn trong container)
echo "→ Tạo symlink mới..."
docker exec $CONTAINER_NAME ln -s /var/www/html/storage/app/public /var/www/html/public/storage

# Kiểm tra quyền
echo "→ Cấp quyền..."
docker exec $CONTAINER_NAME chmod -R 755 /var/www/html/storage/app/public
docker exec $CONTAINER_NAME chown -R www-data:www-data /var/www/html/storage/app/public

# Xác nhận
echo ""
echo "✅ Đã sửa xong!"
echo ""
echo "Kiểm tra symlink:"
docker exec $CONTAINER_NAME ls -la /var/www/html/public/storage
echo ""
echo "Test truy cập ảnh:"
curl -I http://180.93.37.143:8080/storage/placeholder.jpg 2>&1 | grep HTTP
echo ""
echo "Truy cập web: http://180.93.37.143:8080"
