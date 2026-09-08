#!/bin/bash

# FlowerShop CSS Sync Script (Bash)
# Syncs CSS files from resources/css to public/css

SOURCE_DIR="resources/css"
TARGET_DIR="public/css"

# Colors for output
CYAN='\033[0;36m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
WHITE='\033[1;37m'
NC='\033[0m' # No Color

echo -e "${CYAN}FlowerShop CSS Sync${NC}"
echo -e "${CYAN}===================${NC}"
echo ""

# Create target directory if it doesn't exist
if [ ! -d "$TARGET_DIR" ]; then
    mkdir -p "$TARGET_DIR"
    echo -e "${GREEN}Created directory: $TARGET_DIR${NC}"
fi

# Count CSS files
CSS_FILES=("$SOURCE_DIR"/*.css)
FILE_COUNT=${#CSS_FILES[@]}

# Check if any CSS files exist
if [ ! -e "${CSS_FILES[0]}" ]; then
    echo -e "${YELLOW}No CSS files found in $SOURCE_DIR${NC}"
    exit 0
fi

echo -e "${WHITE}Found $FILE_COUNT CSS file(s) to sync${NC}"
echo ""

SYNCED_COUNT=0
ERROR_COUNT=0

# Sync each CSS file
for file in "$SOURCE_DIR"/*.css; do
    if [ -f "$file" ]; then
        filename=$(basename "$file")
        
        if cp "$file" "$TARGET_DIR/$filename"; then
            filesize=$(du -h "$file" | cut -f1)
            echo -e "${GREEN}[OK]${NC} $filename ($filesize)"
            ((SYNCED_COUNT++))
        else
            echo -e "${RED}[ERROR]${NC} Failed to sync $filename"
            ((ERROR_COUNT++))
        fi
    fi
done

echo ""
echo -e "${CYAN}===================${NC}"
echo -e "${GREEN}Synced: $SYNCED_COUNT file(s)${NC}"

if [ $ERROR_COUNT -gt 0 ]; then
    echo -e "${RED}Errors: $ERROR_COUNT file(s)${NC}"
fi

echo -e "${CYAN}Done!${NC}"
