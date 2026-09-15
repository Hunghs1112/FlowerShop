import sys
sys.stdout.reconfigure(encoding='utf-8')
from playwright.sync_api import sync_playwright

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    context = browser.new_context(viewport={"width": 1440, "height": 900})
    page = context.new_page()

    page.goto("http://127.0.0.1:8000/san-pham", wait_until="networkidle", timeout=15000)

    # Full page screenshot
    page.screenshot(path="screenshots/styles_check/san-pham_fullpage.png", full_page=True)
    print("Full page saved")

    # Screenshot just the products section
    grid = page.locator(".products-grid-section")
    if grid.count() > 0:
        grid.screenshot(path="screenshots/styles_check/san-pham_grid.png")
        print("Grid section saved")
        box = grid.bounding_box()
        print(f"Grid bounding box: {box}")

    # Check if grid has any children
    grid_children = page.locator(".products-grid > *").all()
    print(f"Grid children: {len(grid_children)}")

    # Get computed styles
    styles = page.evaluate("""
        () => {
            const grid = document.querySelector('.products-grid');
            if (!grid) return 'no grid found';
            const styles = window.getComputedStyle(grid);
            return {
                display: styles.display,
                gridTemplateColumns: styles.gridTemplateColumns,
                backgroundColor: styles.backgroundColor,
                paddingTop: styles.paddingTop,
            };
        }
    """)
    print(f"Grid computed styles: {styles}")

    browser.close()
