# Script bật Hyper-V cho Docker
# Chạy script này với quyền Administrator

Write-Host "====================================" -ForegroundColor Cyan
Write-Host "  Bật Hyper-V cho Docker Desktop" -ForegroundColor Cyan
Write-Host "====================================" -ForegroundColor Cyan
Write-Host ""

# Kiểm tra quyền Admin
$isAdmin = ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)

if (-not $isAdmin) {
    Write-Host "✗ Cần chạy với quyền Administrator!" -ForegroundColor Red
    Write-Host ""
    Write-Host "Cách chạy:" -ForegroundColor Yellow
    Write-Host "1. Nhấn chuột phải vào PowerShell" -ForegroundColor White
    Write-Host "2. Chọn 'Run as Administrator'" -ForegroundColor White
    Write-Host "3. Chạy lại script này" -ForegroundColor White
    Write-Host ""
    Read-Host "Nhấn Enter để thoát"
    exit 1
}

Write-Host "Đang kiểm tra Hyper-V..." -ForegroundColor Yellow

# Kiểm tra Hyper-V
$hyperv = Get-WindowsOptionalFeature -Online -FeatureName Microsoft-Hyper-V

if ($hyperv.State -eq "Enabled") {
    Write-Host "✓ Hyper-V đã được bật!" -ForegroundColor Green
} else {
    Write-Host "Đang bật Hyper-V..." -ForegroundColor Yellow
    Write-Host "Quá trình này có thể mất vài phút..." -ForegroundColor Cyan
    
    try {
        Enable-WindowsOptionalFeature -Online -FeatureName Microsoft-Hyper-V -All -NoRestart
        Write-Host "✓ Hyper-V đã được bật!" -ForegroundColor Green
    } catch {
        Write-Host "✗ Lỗi khi bật Hyper-V: $_" -ForegroundColor Red
        Read-Host "Nhấn Enter để thoát"
        exit 1
    }
}

Write-Host ""
Write-Host "====================================" -ForegroundColor Green
Write-Host "  Hoàn tất!" -ForegroundColor Green
Write-Host "====================================" -ForegroundColor Green
Write-Host ""
Write-Host "Bước tiếp theo:" -ForegroundColor Cyan
Write-Host "1. Restart máy tính" -ForegroundColor White
Write-Host "2. Mở Docker Desktop" -ForegroundColor White
Write-Host "3. Settings → General → Bỏ tích 'Use WSL 2'" -ForegroundColor White
Write-Host "4. Chạy: .\start-docker.ps1" -ForegroundColor White
Write-Host ""

$restart = Read-Host "Bạn có muốn restart ngay không? (Y/N)"
if ($restart -eq "Y" -or $restart -eq "y") {
    Write-Host "Đang restart..." -ForegroundColor Yellow
    Restart-Computer
} else {
    Write-Host "Nhớ restart máy trước khi dùng Hyper-V nhé!" -ForegroundColor Yellow
}
