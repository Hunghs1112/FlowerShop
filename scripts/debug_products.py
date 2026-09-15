import sys
sys.stdout.reconfigure(encoding='utf-8')
from playwright.sync_api import sync_playwright

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    page = browser.new_page()
    page.goto("http://127.0.0.1:8000/san-pham", wait_until="networkidle", timeout=15000)

    # Get inner HTML of products section
    grid = page.locator(".products-grid-section")
    html = grid.inner_html()
    print("=== Products Grid HTML ===")
    print(html[:3000])

    # Check if empty state shows
    empty = page.locator(".products-empty-state")
    if empty.count() > 0:
        print("\n=== Empty State Visible ===")
        print(empty.inner_text()[:500])
    else:
        print("\n=== No empty state ===")

    # Check for product-card components (Blade components render as their own tags)
    cards = page.locator("x-product-card").all()
    print(f"\n=== x-product-card components: {len(cards)} ===")

    # Check for any div with product-card in class
    prod_divs = page.locator("[class*='product-card']").all()
    print(f"=== Elements with 'product-card' class: {len(prod_divs)} ===")

    # Get all classes on page
    all_divs = page.locator(".products-grid > *").all()
    print(f"\n=== Children of products-grid: {len(all_divs)} ===")
    for d in all_divs[:5]:
        print(f"  tag={d.evaluate('el => el.tagName')}, class={d.get_attribute('class')}")

    # Get main content text length
    main = page.locator("main")
    text = main.inner_text()
    print(f"\n=== Main content ({len(text)} chars) ===")
    print(text[:500])

    browser.close()
