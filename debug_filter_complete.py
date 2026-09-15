from playwright.sync_api import sync_playwright
import os

BASE_URL = "http://127.0.0.1:8000"
os.makedirs("debug_screenshots", exist_ok=True)

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
    
    # Test 1: Normal categories page
    page.goto(f"{BASE_URL}/admin/categories", wait_until="networkidle")
    page.screenshot(path="debug_screenshots/test1_normal.png", full_page=True)
    
    # Get computed styles
    styles_normal = page.evaluate("""
        JSON.stringify({
            bodyBg: getComputedStyle(document.body).backgroundColor,
            bodyColor: getComputedStyle(document.body).color,
            htmlBg: getComputedStyle(document.documentElement).backgroundColor,
            layoutBg: getComputedStyle(document.querySelector('.admin-layout')).backgroundColor,
        })
    """)
    print(f"Normal page styles: {styles_normal}")
    
    # Test 2: Categories with empty filter params
    page.goto(f"{BASE_URL}/admin/categories?search=&status=", wait_until="networkidle")
    page.screenshot(path="debug_screenshots/test2_filter.png", full_page=True)
    
    styles_filter = page.evaluate("""
        JSON.stringify({
            bodyBg: getComputedStyle(document.body).backgroundColor,
            bodyColor: getComputedStyle(document.body).color,
            htmlBg: getComputedStyle(document.documentElement).backgroundColor,
            layoutBg: getComputedStyle(document.querySelector('.admin-layout')).backgroundColor,
        })
    """)
    print(f"Filter page styles: {styles_filter}")
    
    # Compare
    if styles_normal == styles_filter:
        print("\nStyles are IDENTICAL - no color change issue!")
    else:
        print("\nStyles are DIFFERENT - color change detected!")
        print(f"  Normal: {styles_normal}")
        print(f"  Filter: {styles_filter}")
    
    # Test 3: Click filter button (not direct navigation)
    page.goto(f"{BASE_URL}/admin/categories", wait_until="networkidle")
    page.click('.admin-filters button[type="submit"]')
    page.wait_for_load_state("networkidle")
    page.screenshot(path="debug_screenshots/test3_click_filter.png", full_page=True)
    print(f"\nAfter clicking filter, URL: {page.url}")
    
    styles_click = page.evaluate("""
        JSON.stringify({
            bodyBg: getComputedStyle(document.body).backgroundColor,
            bodyColor: getComputedStyle(document.body).color,
            layoutBg: getComputedStyle(document.querySelector('.admin-layout')).backgroundColor,
        })
    """)
    print(f"After click styles: {styles_click}")
    
    # Test 4: Categories with actual search term
    page.goto(f"{BASE_URL}/admin/categories?search=test&status=", wait_until="networkidle")
    page.screenshot(path="debug_screenshots/test4_search.png", full_page=True)
    
    styles_search = page.evaluate("""
        JSON.stringify({
            bodyBg: getComputedStyle(document.body).backgroundColor,
            bodyColor: getComputedStyle(document.body).color,
        })
    """)
    print(f"\nSearch page styles: {styles_search}")
    
    browser.close()
