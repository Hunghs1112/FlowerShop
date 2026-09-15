# ============================================
# FlowerShop - CSS Build Script
# Consolidates public/css/*.css → resources/css/app.css
# ============================================

$ErrorActionPreference = "Stop"

$ProjectRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
$PublicCssDir = Join-Path $ProjectRoot "public\css"
$OutputFile = Join-Path $ProjectRoot "resources\css\app.css"

# CSS file order (foundation first, then components, then pages)
$FileOrder = @(
    "theme.css",
    "base.css",
    "layout.css",
    "components.css",
    "navbar.css",
    "footer.css",
    "page-hero.css",
    "product-card.css",
    "home.css",
    "categories.css",
    "cart.css",
    "checkout.css",
    "auth.css",
    "blog.css",
    "pages.css",
    "profile.css",
    "zalo-info.css"
)

# Products subfolder files
$ProductsFiles = @(
    "products\list.css",
    "products\detail.css",
    "products\filter.css",
    "products\toolbar.css",
    "products\pagination.css"
)

Write-Host "============================================"
Write-Host "FlowerShop CSS Build Script"
Write-Host "============================================"
Write-Host ""

# Start building the output
$Output = @()
$Output += "/* ============================================"
$Output += "   FlowerShop - Consolidated CSS"
$Output += "   Built: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')"
$Output += "   Theme: Modern Bloom (Pink + Mint)"
$Output += "   ============================================ */"
$Output += ""
$Output += "/* --- Foundation --- */"

$ProcessedFiles = @()

# Process ordered files
foreach ($file in $FileOrder) {
    $filePath = Join-Path $PublicCssDir $file
    if (Test-Path $filePath) {
        $content = Get-Content $filePath -Raw -Encoding UTF8
        if ($content) {
            $Output += ""
            $Output += "/* --- $file --- */"
            $Output += $content.Trim()
            $ProcessedFiles += $file
        }
    }
}

# Process products subfolder
$Output += ""
$Output += "/* --- Products --- */"
foreach ($file in $ProductsFiles) {
    $filePath = Join-Path $PublicCssDir $file
    if (Test-Path $filePath) {
        $content = Get-Content $filePath -Raw -Encoding UTF8
        if ($content) {
            $Output += ""
            $Output += "/* --- $file --- */"
            $Output += $content.Trim()
            $ProcessedFiles += $file
        }
    }
}

# Process any remaining files not in the ordered list
$Output += ""
$Output += "/* --- Additional Files --- */"
Get-ChildItem $PublicCssDir -Filter "*.css" -Recurse | ForEach-Object {
    $relativePath = $_.FullName.Replace($PublicCssDir + "\", "").Replace("\", "/")
    if ($relativePath -notin $ProcessedFiles) {
        Write-Host "  Adding additional: $relativePath"
        $content = Get-Content $_.FullName -Raw -Encoding UTF8
        if ($content) {
            $Output += ""
            $Output += "/* --- $relativePath --- */"
            $Output += $content.Trim()
        }
    }
}

# Write output file
$OutputText = $Output -join "`n"
[System.IO.File]::WriteAllText($OutputFile, $OutputText, [System.Text.Encoding]::UTF8)

$OutputSize = (Get-Item $OutputFile).Length
$OutputSizeKB = [math]::Round($OutputSize / 1024, 1)

Write-Host ""
Write-Host "============================================"
Write-Host "Build Complete!"
Write-Host "============================================"
Write-Host "Output: $OutputFile"
Write-Host "Size: $OutputSizeKB KB"
Write-Host "Files processed: $($ProcessedFiles.Count)"
Write-Host ""
Write-Host "Next steps:"
Write-Host "  1. Run `npm run build` to build Vite assets"
Write-Host "  2. Clear cache if needed: php artisan cache:clear"
