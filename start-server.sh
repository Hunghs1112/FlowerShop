#!/bin/bash
# 启动 Laravel 开发服务器
# 用法: bash start-server.sh

cd /root/FlowerShop

echo "=== 启动花店系统 ==="
echo ""
echo "VPS IP: $(hostname -I | awk '{print $1}')"
echo "端口: 8000"
echo ""

# 检查端口是否被占用
if netstat -tlnp | grep -q ":8000 "; then
    echo "⚠️  端口 8000 已被占用"
    echo "正在停止旧进程..."
    pkill -f "php artisan serve"
    sleep 2
fi

# 清除缓存
echo "清除缓存..."
php artisan cache:clear > /dev/null 2>&1
php artisan config:clear > /dev/null 2>&1
php artisan view:clear > /dev/null 2>&1

# 启动服务器
echo ""
echo "✅ 启动服务器..."
echo ""
echo "访问地址："
echo "  本地: http://localhost:8000"
echo "  外部: http://$(hostname -I | awk '{print $1}'):8000"
echo ""
echo "后台管理："
echo "  地址: http://$(hostname -I | awk '{print $1}'):8000/admin"
echo "  账号: admin@flowershop.com"
echo "  密码: password"
echo ""
echo "按 Ctrl+C 停止服务器"
echo ""

php artisan serve --host=0.0.0.0 --port=8000
