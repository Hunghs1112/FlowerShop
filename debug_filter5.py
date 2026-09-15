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
    
    # Check form action
    form_action = page.evaluate("""
        document.querySelector('.admin-filters').getAttribute('action')
    """)
    form_method = page.evaluate("""
        document.querySelector('.admin-filters').getAttribute('method')
    """)
    print(f"Form action: {form_action}")
    print(f"Form method: {form_method}")
    
    # Try to submit form manually with fetch
    result = page.evaluate("""
        async () => {
            const form = document.querySelector('.admin-filters');
            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();
            const action = form.getAttribute('action') || window.location.pathname;
            const fullUrl = action + (params ? '?' + params : '');
            return { url: fullUrl, params: params };
        }
    """)
    print(f"Form submission URL would be: {result['url']}")
    print(f"Form params: {result['params']}")
    
    # Check if there are any other forms on the page
    forms = page.locator('form').all()
    print(f"\nTotal forms on page: {len(forms)}")
    for i, form in enumerate(forms):
        action = form.get_attribute('action')
        method = form.get_attribute('method')
        print(f"  Form {i}: action={action}, method={method}")
    
    browser.close()
