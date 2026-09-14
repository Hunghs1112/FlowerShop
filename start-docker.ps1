# FlowerShop Docker 启动脚本
# 这个脚本会自动检查环境并启动 Docker 容器

Write-Host "====================================" -ForegroundColor Cyan
Write-Host "  FlowerShop Docker 启动脚本" -ForegroundColor Cyan
Write-Host "====================================" -ForegroundColor Cyan
Write-Host ""

# 检查 Docker 是否安装
Write-Host "检查 Docker 是否已安装..." -ForegroundColor Yellow
try {
    $dockerVersion = docker --version
    Write-Host "✓ Docker 已安装: $dockerVersion" -ForegroundColor Green
} catch {
    Write-Host "✗ Docker 未安装！" -ForegroundColor Red
    Write-Host ""
    Write-Host "请按照以下步骤安装 Docker Desktop:" -ForegroundColor Yellow
    Write-Host "1. 访问: https://www.docker.com/products/docker-desktop" -ForegroundColor White
    Write-Host "2. 下载并安装 Docker Desktop for Windows" -ForegroundColor White
    Write-Host "3. 重启计算机" -ForegroundColor White
    Write-Host "4. 启动 Docker Desktop" -ForegroundColor White
    Write-Host "5. 重新运行此脚本" -ForegroundColor White
    Write-Host ""
    Read-Host "按 Enter 键退出"
    exit 1
}

# 检查 Docker 是否运行
Write-Host "检查 Docker 是否正在运行..." -ForegroundColor Yellow
try {
    docker ps | Out-Null
    Write-Host "✓ Docker 正在运行" -ForegroundColor Green
} catch {
    Write-Host "✗ Docker 未运行！" -ForegroundColor Red
    Write-Host "请启动 Docker Desktop 后重试" -ForegroundColor Yellow
    Write-Host ""
    Read-Host "按 Enter 键退出"
    exit 1
}

# 检查 .env 文件
Write-Host "检查环境配置文件..." -ForegroundColor Yellow
if (-Not (Test-Path ".env")) {
    Write-Host "✓ 创建 .env 文件..." -ForegroundColor Green
    Copy-Item ".env.example" ".env"
} else {
    Write-Host "✓ .env 文件已存在" -ForegroundColor Green
}

# 停止旧容器
Write-Host ""
Write-Host "停止旧容器（如果存在）..." -ForegroundColor Yellow
docker-compose down 2>$null

# 构建并启动容器
Write-Host ""
Write-Host "构建并启动容器..." -ForegroundColor Yellow
Write-Host "这可能需要几分钟时间，请耐心等待..." -ForegroundColor Cyan
Write-Host ""

docker-compose up -d --build

if ($LASTEXITCODE -eq 0) {
    Write-Host ""
    Write-Host "====================================" -ForegroundColor Green
    Write-Host "  ✓ Docker 容器启动成功！" -ForegroundColor Green
    Write-Host "====================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "访问地址:" -ForegroundColor Cyan
    Write-Host "  网站: http://localhost:8080" -ForegroundColor White
    Write-Host "  数据库: localhost:3307" -ForegroundColor White
    Write-Host ""
    Write-Host "常用命令:" -ForegroundColor Cyan
    Write-Host "  查看日志: docker-compose logs -f app" -ForegroundColor White
    Write-Host "  停止容器: docker-compose stop" -ForegroundColor White
    Write-Host "  重启容器: docker-compose restart" -ForegroundColor White
    Write-Host ""
    
    # 等待容器完全启动
    Write-Host "等待容器完全启动..." -ForegroundColor Yellow
    Start-Sleep -Seconds 10
    
    # 显示容器状态
    Write-Host "容器状态:" -ForegroundColor Cyan
    docker-compose ps
    
    Write-Host ""
    Write-Host "正在打开浏览器..." -ForegroundColor Yellow
    Start-Sleep -Seconds 2
    Start-Process "http://localhost:8080"
    
} else {
    Write-Host ""
    Write-Host "====================================" -ForegroundColor Red
    Write-Host "  ✗ 启动失败！" -ForegroundColor Red
    Write-Host "====================================" -ForegroundColor Red
    Write-Host ""
    Write-Host "查看错误日志:" -ForegroundColor Yellow
    docker-compose logs
}

Write-Host ""
Read-Host "按 Enter 键退出"
