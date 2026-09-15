from playwright.sync_api import sync_playwright

BASE_URL = "http://127.0.0.1:8000"

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    context = browser.new_context(viewport={"width": 1440, "height": 900})
    page = context.new_page()
    
    # Listen for network requests
    requests = []
    page.on("request", lambda req: requests.append(f"REQ: {req.method} {req.url}") if 'css' in req.url.lower() else None)
    page.on("response", lambda res: requests.append(f"RES: {res.status} {res.url}") if 'css' in res.url.lower() else None)
    
    # Login
    page.goto(f"{BASE_URL}/login", wait_until="networkidle")
    page.fill('input[name="email"]', 'admin@lamnhienthao.vn')
    page.fill('input[name="password"]', 'password')
    page.locator('#login-btn').click()
    page.wait_for_load_state("networkidle")
    
    requests.clear()
    
    # Normal page
    page.goto(f"{BASE_URL}/admin/categories", wait_until="networkidle")
    normal_req_count = len(requests)
    print(f"Normal page - CSS requests: {normal_req_count}")
    for r in requests:
        print(f"  {r}")
    
    requests.clear()
    
    # Filter page
    page.goto(f"{BASE_URL}/admin/categories?search=&status=", wait_until="networkidle")
    filter_req_count = len(requests)
    print(f"\nFilter page - CSS requests: {filter_req_count}")
    for r in requests:
        print(f"  {r}")
    
    # Check all CSS rules being applied
    print("\n\nKey computed styles on filter page:")
    for sel in ['.admin-card', '.admin-table', '.admin-filters', '.btn']:
        try:
            color = page.evaluate(f"getComputedStyle(document.querySelector('{sel}')).color")
            bg = page.evaluate(f"getComputedStyle(document.querySelector('{sel}')).backgroundColor")
            print(f"  {sel}: color={color}, bg={bg}")
        except:
            print(f"  {sel}: not found")
    
    browser.close()
