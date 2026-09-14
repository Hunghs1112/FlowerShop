# 双语功能测试脚本

Write-Host "=====================================" -ForegroundColor Cyan
Write-Host "双语功能测试" -ForegroundColor Cyan
Write-Host "=====================================" -ForegroundColor Cyan
Write-Host ""

# 1. 检查路由
Write-Host "1. 检查语言切换路由..." -ForegroundColor Yellow
php artisan route:list --name=locale.switch
Write-Host ""

# 2. 检查首页路由
Write-Host "2. 检查首页路由..." -ForegroundColor Yellow
php artisan route:list --name=home
Write-Host ""

# 3. 检查辅助函数
Write-Host "3. 测试辅助函数..." -ForegroundColor Yellow
php artisan tinker --execute="echo locale_route('home') . PHP_EOL;"
Write-Host ""

# 4. 清除所有缓存
Write-Host "4. 清除缓存..." -ForegroundColor Yellow
php artisan optimize:clear
Write-Host ""

Write-Host "=====================================" -ForegroundColor Green
Write-Host "测试完成！" -ForegroundColor Green
Write-Host "=====================================" -ForegroundColor Green
Write-Host ""
Write-Host "请在浏览器中测试以下内容：" -ForegroundColor White
Write-Host "1. 访问：http://127.0.0.1:8000/vi" -ForegroundColor White
Write-Host "2. 点击导航栏右上角的语言切换按钮（EN/VI）" -ForegroundColor White
Write-Host "3. 验证页面是否正确切换语言并保持在相同页面" -ForegroundColor White
Write-Host "4. 测试所有导航链接是否正常工作" -ForegroundColor White
Write-Host ""
