# =============================================================================
# FlowerShop CSS Build Script
# Consolidates modular CSS files into public/css/app.css
# =============================================================================

Write-Host "Building CSS..." -ForegroundColor Cyan

# Define source files in order (cascade matters)
$sourceFiles = @(
    "theme.css",
    "reset.css",
    "base.css",
    "typography.css",
    "layout.css",
    "buttons.css",
    "forms.css",
    "cards.css",
    "badges.css",
    "product-card.css",
    "navbar.css",
    "footer.css",
    "page-hero.css",
    "hero.css",
    "products-section.css",
    "categories-section.css",
    "brand-values-section.css",
    "inspiration-section.css",
    "instagram-section.css",
    "partners-section.css",
    "products/hero.css",
    "products/filter-chips.css",
    "products/index.css",
    "products/filter.css",
    "products/toolbar.css",
    "products/grid-section.css",
    "products/grid.css",
    "products/pagination.css",
    "products/detail.css",
    "products/detail-responsive.css",
    "products/recommended.css",
    "products/editorial.css",
    "reference-pages.css",
    "cart.css",
    "checkout.css",
    "contact.css",
    "account.css",
    "profile.css",
    "favorites.css",
    "blog.css",
    "auth.css",
    "chat.css",
    "chat-button.css",
    "admin.css",
    "admin/sidebar.css",
    "admin/dashboard.css",
    "admin/tables.css",
    "admin/forms.css",
    "admin/chat.css"
)

$basePath = "public/css"
$outputFile = "$basePath/app.css"

# Start building
$output = @"
/* ==========================================================================
   FlowerShop - Premium Botanical Theme
   Generated: $(Get-Date -Format "yyyy-MM-dd HH:mm:ss")
   ========================================================================== */

"@

$successCount = 0
$missingFiles = @()

foreach ($file in $sourceFiles) {
    $filePath = Join-Path $basePath $file
    
    if (Test-Path $filePath) {
        Write-Host "  + $file" -ForegroundColor Green
        $content = Get-Content $filePath -Raw -Encoding UTF8
        $output += "`n/* === $file === */`n"
        $output += $content
        $output += "`n"
        $successCount++
    } else {
        Write-Host "  - $file (not found, skipping)" -ForegroundColor Yellow
        $missingFiles += $file
    }
}

# Write consolidated CSS
$output | Set-Content $outputFile -Encoding UTF8 -NoNewline

Write-Host "`nBuild complete!" -ForegroundColor Green
Write-Host "  Merged: $successCount files" -ForegroundColor Cyan
Write-Host "  Output: $outputFile" -ForegroundColor Cyan

if ($missingFiles.Count -gt 0) {
    Write-Host "`nSkipped files (not yet created):" -ForegroundColor Yellow
    $missingFiles | ForEach-Object { Write-Host "  - $_" -ForegroundColor Yellow }
}

# Show file size
$size = (Get-Item $outputFile).Length
$sizeKB = [math]::Round($size / 1KB, 2)
Write-Host "`nGenerated CSS: $sizeKB KB" -ForegroundColor Cyan

if ($sizeKB -gt 150) {
    Write-Host "Warning: CSS file is larger than 150KB target" -ForegroundColor Yellow
} else {
    Write-Host "CSS size within target" -ForegroundColor Green
}
