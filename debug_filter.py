from playwright.sync_api import sync_playwright

BASE_URL = "http://127.0.0.1:8000"

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    context = browser.new_context(viewport={"width": 1440, "height": 900})
    page = context.new_page()
    
    # Login
    page.goto(f"{BASE_URL}/login", wait_until="networkidle")
    page.fill('input[name="email"]', 'admin@lamnhienthao.vn')
    page.fill('input[name="password"]', 'password')
    page.locator('#login-btn').click()
    page.wait_for_load_state("networkidle")
    
    # Go to categories with filter
    print("Test 1: Normal categories page")
    page.goto(f"{BASE_URL}/admin/categories", wait_until="networkidle")
    page.screenshot(path="debug_01_normal.png", full_page=True)
    print(f"URL: {page.url}")
    
    # Check body background
    bg = page.evaluate("getComputedStyle(document.body).backgroundColor")
    print(f"Body background: {bg}")
    
    # Check admin-layout
    layout_bg = page.evaluate("getComputedStyle(document.querySelector('.admin-layout')).backgroundColor")
    print(f"Admin layout background: {layout_bg}")
    
    # Test with query params
    print("\nTest 2: Categories with filter")
    page.goto(f"{BASE_URL}/admin/categories?search=&status=", wait_until="networkidle")
    page.screenshot(path="debug_02_filter.png", full_page=True)
    print(f"URL: {page.url}")
    
    # Check body background
    bg = page.evaluate("getComputedStyle(document.body).backgroundColor")
    print(f"Body background: {bg}")
    
    # Check admin-layout
    layout_bg = page.evaluate("getComputedStyle(document.querySelector('.admin-layout')).backgroundColor")
    print(f"Admin layout background: {layout_bg}")
    
    # Check computed styles on key elements
    print("\nAll key element backgrounds:")
    for sel in ['body', '.admin-layout', '.admin-sidebar', '.admin-content', '.admin-topbar']:
        bg = page.evaluate(f"getComputedStyle(document.querySelector('{sel}')).backgroundColor")
        print(f"  {sel}: {bg}")
    
    browser.close()
