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
    
    # Normal page
    page.goto(f"{BASE_URL}/admin/categories", wait_until="networkidle")
    page.screenshot(path="debug_screenshots/normal_full.png", full_page=True)
    print(f"Normal page URL: {page.url}")
    
    # Filter page - without any params
    page.goto(f"{BASE_URL}/admin/categories", wait_until="networkidle")
    # Click filter button to trigger form submission
    page.click('button[type="submit"]')
    page.wait_for_load_state("networkidle")
    page.screenshot(path="debug_screenshots/filter_submit_full.png", full_page=True)
    print(f"After filter submit URL: {page.url}")
    
    # Direct filter page
    page.goto(f"{BASE_URL}/admin/categories?search=&status=", wait_until="networkidle")
    page.screenshot(path="debug_screenshots/filter_direct_full.png", full_page=True)
    print(f"Filter direct URL: {page.url}")
    
    # Check the HTML structure for any differences
    print("\nChecking for hidden elements or overlays...")
    
    # Check for any full-screen overlays
    overlays = page.locator('[class*="overlay"], [class*="modal"], [class*="dark"]').all()
    print(f"Overlays/modal/dark elements found: {len(overlays)}")
    
    # Check the sidebar color
    sidebar_bg = page.evaluate("getComputedStyle(document.querySelector('.admin-sidebar')).backgroundColor")
    print(f"Sidebar background: {sidebar_bg}")
    
    # Check the main content area
    content_bg = page.evaluate("getComputedStyle(document.querySelector('.admin-content')).backgroundColor")
    print(f"Content background: {content_bg}")
    
    browser.close()
