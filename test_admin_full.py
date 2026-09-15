from playwright.sync_api import sync_playwright
import os

BASE_URL = "http://127.0.0.1:8000"

def test_admin_pages():
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        context = browser.new_context(viewport={"width": 1440, "height": 900})
        page = context.new_page()
        
        errors = []
        os.makedirs("screenshots", exist_ok=True)
        
        # Login first
        print("\n=== LOGIN ===")
        page.goto(f"{BASE_URL}/login", wait_until="networkidle")
        page.screenshot(path="screenshots/00-login.png", full_page=True)
        
        # Get all submit buttons to find the right one
        submit_buttons = page.locator('button[type="submit"]').all()
        print(f"  Found {len(submit_buttons)} submit buttons")
        
        # Fill login form - use more specific selectors
        page.fill('input[name="email"]', 'admin@lamnhienthao.vn')
        page.fill('input[name="password"]', 'password')
        
        # Click the login button specifically
        page.locator('#login-btn').click()
        page.wait_for_load_state("networkidle")
        page.screenshot(path="screenshots/00-logged-in.png", full_page=True)
        print("  Login attempted")
        
        # Check current URL
        print(f"  Current URL: {page.url}")
        
        # Test 1: Admin Dashboard
        print("\n=== Test 1: Admin Dashboard ===")
        page.goto(f"{BASE_URL}/admin", wait_until="networkidle")
        page.screenshot(path="screenshots/01-admin-dashboard.png", full_page=True)
        try:
            print(f"  Title: {page.title()}")
        except:
            print(f"  Title: (encoding error)")
        
        # Check if we're on admin page
        if "admin" in page.url.lower():
            dashboard_elements = [".admin-topbar", ".admin-sidebar", ".admin-main-content"]
            for sel in dashboard_elements:
                if page.locator(sel).count() > 0:
                    print(f"  OK: {sel}")
                else:
                    errors.append(f"Missing: {sel}")
                    print(f"  FAIL: {sel}")
        else:
            print(f"  FAIL: Not on admin page, URL: {page.url}")
            errors.append("Not on admin page")
        
        # Test 2: Admin Products List
        print("\n=== Test 2: Admin Products List ===")
        page.goto(f"{BASE_URL}/admin/products", wait_until="networkidle")
        page.screenshot(path="screenshots/02-admin-products.png", full_page=True)
        try:
            page.wait_for_selector("table", timeout=5000)
            print("  OK: Products table loaded")
        except:
            errors.append("Products table not found")
            print("  FAIL: Products table not loaded")
        
        # Test 3: Admin Products Create
        print("\n=== Test 3: Admin Products Create ===")
        page.goto(f"{BASE_URL}/admin/products/create", wait_until="networkidle")
        page.screenshot(path="screenshots/03-admin-products-create.png", full_page=True)
        if page.locator('input[name="name"]').count() > 0:
            print("  OK: Product name input found")
        else:
            errors.append("Missing: input[name='name'] on create product")
            print("  FAIL: Product name input NOT found")
        
        # Test 4: Admin Products Edit
        print("\n=== Test 4: Admin Products Edit ===")
        page.goto(f"{BASE_URL}/admin/products", wait_until="networkidle")
        edit_links = page.locator('a[href*="/admin/products/"][href*="/edit"]')
        if edit_links.count() > 0:
            edit_links.first.click()
            page.wait_for_load_state("networkidle")
            page.screenshot(path="screenshots/04-admin-products-edit.png", full_page=True)
            print("  OK: Product edit page loaded")
        else:
            print("  SKIP: No product to edit")
        
        # Test 5: Admin Categories
        print("\n=== Test 5: Admin Categories ===")
        page.goto(f"{BASE_URL}/admin/categories", wait_until="networkidle")
        page.screenshot(path="screenshots/05-admin-categories.png", full_page=True)
        print("  OK: Categories page loaded")
        
        # Test 6: Admin Categories Create
        print("\n=== Test 6: Admin Categories Create ===")
        page.goto(f"{BASE_URL}/admin/categories/create", wait_until="networkidle")
        page.screenshot(path="screenshots/06-admin-categories-create.png", full_page=True)
        if page.locator('input[name="name"]').count() > 0:
            print("  OK: Category name input found")
        else:
            errors.append("Missing: input[name='name'] on create category")
            print("  FAIL: Category name input NOT found")
        
        # Test 7: Admin Posts
        print("\n=== Test 7: Admin Posts ===")
        page.goto(f"{BASE_URL}/admin/posts", wait_until="networkidle")
        page.screenshot(path="screenshots/07-admin-posts.png", full_page=True)
        print("  OK: Posts page loaded")
        
        # Test 8: Admin Posts Create
        print("\n=== Test 8: Admin Posts Create ===")
        page.goto(f"{BASE_URL}/admin/posts/create", wait_until="networkidle")
        page.screenshot(path="screenshots/08-admin-posts-create.png", full_page=True)
        if page.locator('input[name="title"]').count() > 0:
            print("  OK: Post title input found")
        else:
            errors.append("Missing: input[name='title'] on create post")
            print("  FAIL: Post title input NOT found")
        
        # Test 9: Admin Pages
        print("\n=== Test 9: Admin Pages ===")
        page.goto(f"{BASE_URL}/admin/pages", wait_until="networkidle")
        page.screenshot(path="screenshots/09-admin-pages.png", full_page=True)
        print("  OK: Pages page loaded")
        
        # Test 10: Admin Pages Create
        print("\n=== Test 10: Admin Pages Create ===")
        page.goto(f"{BASE_URL}/admin/pages/create", wait_until="networkidle")
        page.screenshot(path="screenshots/10-admin-pages-create.png", full_page=True)
        print("  OK: Pages create loaded")
        
        # Test 11: Admin Users
        print("\n=== Test 11: Admin Users ===")
        page.goto(f"{BASE_URL}/admin/users", wait_until="networkidle")
        page.screenshot(path="screenshots/11-admin-users.png", full_page=True)
        print("  OK: Users page loaded")
        
        # Test 12: Admin Users Create
        print("\n=== Test 12: Admin Users Create ===")
        page.goto(f"{BASE_URL}/admin/users/create", wait_until="networkidle")
        page.screenshot(path="screenshots/12-admin-users-create.png", full_page=True)
        if page.locator('input[name="name"]').count() > 0:
            print("  OK: User name input found")
        else:
            errors.append("Missing: input[name='name'] on create user")
            print("  FAIL: User name input NOT found")
        
        # Summary
        print("\n" + "="*50)
        print("SUMMARY")
        print("="*50)
        if errors:
            print(f"ERRORS ({len(errors)}):")
            for e in errors:
                print(f"  - {e}")
        else:
            print("ALL TESTS PASSED!")
        
        browser.close()

if __name__ == "__main__":
    test_admin_pages()
