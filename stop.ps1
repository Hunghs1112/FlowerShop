# 停止 FlowerShop
Write-Host "正在停止 FlowerShop..." -ForegroundColor Yellow
docker-compose stop
Write-Host "✓ 已停止所有容器" -ForegroundColor Green
