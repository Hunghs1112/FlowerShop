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
    
    # Check session cookie
    cookies = context.cookies()
    session_cookie = [c for c in cookies if 'session' in c['name'].lower()]
    print(f"Session cookies: {len(session_cookie)}")
    for c in session_cookie:
        print(f"  - {c['name']}: {c['value'][:20]}...")
    
    # Navigate to categories with filter params directly
    print(f"\nNavigating to: {BASE_URL}/admin/categories?search=&status=")
    response = page.goto(f"{BASE_URL}/admin/categories?search=&status=", wait_until="networkidle")
    
    print(f"Response status: {response.status}")
    print(f"Final URL: {page.url}")
    print(f"Page title: {page.title()}")
    
    # Check if we're logged in
    if '/login' in page.url:
        print("REDIRECTED TO LOGIN - Session lost!")
    elif '/admin' in page.url:
        print("Still on admin page - session OK")
    else:
        print(f"Unexpected URL: {page.url}")
    
    # Check key elements
    sidebar = page.locator('.admin-sidebar')
    topbar = page.locator('.admin-topbar')
    content = page.locator('.admin-content')
    
    print(f"\nKey elements:")
    print(f"  Sidebar found: {sidebar.count() > 0}")
    print(f"  Topbar found: {topbar.count() > 0}")
    print(f"  Content found: {content.count() > 0}")
    
    # Take screenshot
    page.screenshot(path="debug_filter_final.png", full_page=True)
    print("\nScreenshot saved to debug_filter_final.png")
    
    browser.close()
