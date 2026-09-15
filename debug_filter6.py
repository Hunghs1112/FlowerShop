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
    
    print(f"After login URL: {page.url}")
    
    # Go to categories page
    page.goto(f"{BASE_URL}/admin/categories", wait_until="networkidle")
    print(f"Categories URL: {page.url}")
    
    # Get all forms
    forms = page.locator('form').all()
    print(f"\nTotal forms: {len(forms)}")
    
    # Find the filter form and check all its children
    filter_form = page.locator('.admin-filters').first
    
    # Check all buttons in the form
    buttons = filter_form.locator('button').all()
    print(f"Buttons in filter form: {len(buttons)}")
    for btn in buttons:
        print(f"  - button: type={btn.get_attribute('type')}, text={btn.inner_text()}")
    
    # Check all inputs in the form
    inputs = filter_form.locator('input').all()
    print(f"Inputs in filter form: {len(inputs)}")
    for inp in inputs:
        print(f"  - input: name={inp.get_attribute('name')}, type={inp.get_attribute('type')}, value={inp.get_attribute('value')}")
    
    selects = filter_form.locator('select').all()
    print(f"Selects in filter form: {len(selects)}")
    for sel in selects:
        print(f"  - select: name={sel.get_attribute('name')}")
        options = sel.locator('option').all()
        for opt in options:
            print(f"      option: value={opt.get_attribute('value')}, text={opt.inner_text()}")
    
    # Try clicking the filter submit button specifically
    print("\nClicking filter submit button...")
    filter_form.locator('button[type="submit"]').click()
    page.wait_for_load_state("networkidle")
    print(f"After click URL: {page.url}")
    
    # Check if we're still logged in
    if '/admin' in page.url:
        print("Still on admin page - OK")
    else:
        print(f"NOT on admin page! URL: {page.url}")
        # Check page content
        title = page.title()
        print(f"Page title: {title}")
        
        # Check if login form is visible
        login_form = page.locator('#login-btn')
        if login_form.count() > 0:
            print("Login form is visible - user was logged out!")
    
    browser.close()
