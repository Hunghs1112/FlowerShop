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
    
    # Normal page
    page.goto(f"{BASE_URL}/admin/categories", wait_until="networkidle")
    normal_body = page.evaluate("""
        JSON.stringify({
            color: getComputedStyle(document.body).color,
            backgroundColor: getComputedStyle(document.body).backgroundColor,
            fontFamily: getComputedStyle(document.body).fontFamily,
        })
    """)
    
    # Filter page
    page.goto(f"{BASE_URL}/admin/categories?search=&status=", wait_until="networkidle")
    filter_body = page.evaluate("""
        JSON.stringify({
            color: getComputedStyle(document.body).color,
            backgroundColor: getComputedStyle(document.body).backgroundColor,
            fontFamily: getComputedStyle(document.body).fontFamily,
        })
    """)
    
    print(f"Normal page body: {normal_body}")
    print(f"Filter page body: {filter_body}")
    
    # Check if stylesheets loaded
    stylesheets = page.evaluate("""
        Array.from(document.querySelectorAll('link[rel="stylesheet"]')).map(l => l.href)
    """)
    print(f"\nLoaded stylesheets:")
    for s in stylesheets:
        print(f"  {s}")
    
    # Check for any inline styles or class changes on body/html
    body_classes = page.evaluate("document.body.className")
    html_classes = page.evaluate("document.documentElement.className")
    print(f"\nBody classes: '{body_classes}'")
    print(f"HTML classes: '{html_classes}'")
    
    # Check computed styles on .admin-card (the main content card)
    card_color = page.evaluate("getComputedStyle(document.querySelector('.admin-card')).color")
    card_bg = page.evaluate("getComputedStyle(document.querySelector('.admin-card')).backgroundColor")
    print(f"\nAdmin card color: {card_color}")
    print(f"Admin card bg: {card_bg}")
    
    browser.close()
