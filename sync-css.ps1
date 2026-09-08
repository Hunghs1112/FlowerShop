# FlowerShop CSS Sync Script (PowerShell)
# Syncs CSS files from resources/css to public/css

$sourceDir = "resources/css"
$targetDir = "public/css"

Write-Host "FlowerShop CSS Sync" -ForegroundColor Cyan
Write-Host "===================" -ForegroundColor Cyan
Write-Host ""

# Create target directory if it doesn't exist
if (-not (Test-Path $targetDir)) {
    New-Item -ItemType Directory -Path $targetDir -Force | Out-Null
    Write-Host "Created directory: $targetDir" -ForegroundColor Green
}

# Get all CSS files from source
$cssFiles = Get-ChildItem -Path $sourceDir -Filter "*.css"

if ($cssFiles.Count -eq 0) {
    Write-Host "No CSS files found in $sourceDir" -ForegroundColor Yellow
    exit
}

Write-Host "Found $($cssFiles.Count) CSS file(s) to sync" -ForegroundColor White
Write-Host ""

$syncedCount = 0
$errorCount = 0

foreach ($file in $cssFiles) {
    try {
        $sourcePath = $file.FullName
        $targetPath = Join-Path $targetDir $file.Name
        
        Copy-Item -Path $sourcePath -Destination $targetPath -Force
        
        $fileSize = [math]::Round($file.Length / 1KB, 2)
        Write-Host "[OK] $($file.Name) ($fileSize KB)" -ForegroundColor Green
        $syncedCount++
    }
    catch {
        Write-Host "[ERROR] Failed to sync $($file.Name): $($_.Exception.Message)" -ForegroundColor Red
        $errorCount++
    }
}

Write-Host ""
Write-Host "===================" -ForegroundColor Cyan
Write-Host "Synced: $syncedCount file(s)" -ForegroundColor Green

if ($errorCount -gt 0) {
    Write-Host "Errors: $errorCount file(s)" -ForegroundColor Red
}

Write-Host "Done!" -ForegroundColor Cyan
