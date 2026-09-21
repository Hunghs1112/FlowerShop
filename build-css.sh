#!/bin/bash
# =============================================================================
# FlowerShop CSS Build Script
# Consolidates modular CSS files into public/css/app.css
# =============================================================================

echo "Building CSS..."

# Define source files in order (cascade matters)
sourceFiles=(
    "theme.css"
    "reset.css"
    "base.css"
    "typography.css"
    "layout.css"
    "buttons.css"
    "forms.css"
    "cards.css"
    "badges.css"
    "product-card.css"
    "navbar.css"
    "footer.css"
    "page-hero.css"
    "hero.css"
    "products-section.css"
    "categories-section.css"
    "brand-values-section.css"
    "inspiration-section.css"
    "instagram-section.css"
    "partners-section.css"
    "products/hero.css"
    "products/filter-chips.css"
    "products/index.css"
    "products/filter.css"
    "products/toolbar.css"
    "products/grid-section.css"
    "products/grid.css"
    "products/pagination.css"
    "products/detail.css"
    "products/detail-responsive.css"
    "products/recommended.css"
    "products/editorial.css"
    "cart.css"
    "checkout.css"
    "contact.css"
    "account.css"
    "profile.css"
    "favorites.css"
    "blog.css"
    "auth.css"
    "chat.css"
    "chat-button.css"
    "admin.css"
    "admin/sidebar.css"
    "admin/dashboard.css"
    "admin/tables.css"
    "admin/forms.css"
    "admin/chat.css"
)

basePath="public/css"
outputFile="$basePath/app.css"

# Start building
cat > "$outputFile" << EOF
/* ==========================================================================
   FlowerShop - Premium Botanical Theme
   Generated: $(date '+%Y-%m-%d %H:%M:%S')
   ========================================================================== */

EOF

successCount=0
missingFiles=()

for file in "${sourceFiles[@]}"; do
    filePath="$basePath/$file"
    
    if [ -f "$filePath" ]; then
        echo "  + $file"
        echo "" >> "$outputFile"
        echo "/* === $file === */" >> "$outputFile"
        cat "$filePath" >> "$outputFile"
        echo "" >> "$outputFile"
        ((successCount++))
    else
        echo "  - $file (not found, skipping)"
        missingFiles+=("$file")
    fi
done

echo ""
echo "Build complete!"
echo "  Merged: $successCount files"
echo "  Output: $outputFile"

if [ ${#missingFiles[@]} -gt 0 ]; then
    echo ""
    echo "Skipped files (not yet created):"
    for file in "${missingFiles[@]}"; do
        echo "  - $file"
    done
fi

# Show file size
size=$(stat -c%s "$outputFile" 2>/dev/null || stat -f%z "$outputFile" 2>/dev/null)
sizeKB=$(echo "scale=2; $size / 1024" | bc)
echo ""
echo "Generated CSS: ${sizeKB} KB"

# Check size threshold
if (( $(echo "$sizeKB > 150" | bc -l) )); then
    echo "Warning: CSS file is larger than 150KB target"
else
    echo "CSS size within target"
fi
