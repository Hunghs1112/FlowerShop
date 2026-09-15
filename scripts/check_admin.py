import sys
sys.stdout.reconfigure(encoding='utf-8')
from playwright.sync_api import sync_playwright
import os

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    context = browser.new_context(viewport={"width": 1440, "height": 900})
    page = context.new_page()

    # Login first
    page.goto("http://127.0.0.1:8000/login", wait_until="networkidle")
    page.fill("input[name='email']", "admin@flowershop.local")
    page.fill("input[name='password']", "password")
    page.click("button[type='submit']")
    page.wait_for_load_state("networkidle")
    print("Logged in")

    # Admin dashboard
    page.goto("http://127.0.0.1:8000/admin", wait_until="networkidle")
    page.screenshot(path="screenshots/styles_check/admin_dashboard_full.png", full_page=True)
    print("Admin dashboard saved")

    # Admin products
    page.goto("http://127.0.0.1:8000/admin/products", wait_until="networkidle")
    page.screenshot(path="screenshots/styles_check/admin_products_full.png", full_page=True)
    print("Admin products saved")

    # Check CSS loaded
    failed = []
    def on_response(resp):
        if resp.status >= 400 and 'css' in resp.url:
            failed.append(f"HTTP {resp.status}: {resp.url}")
    page.on("response", on_response)

    # Reload and check
    page.goto("http://127.0.0.1:8000/admin", wait_until="networkidle")
    print(f"CSS 404s: {failed}")

    # Check key element styles
    info = page.evaluate("""
        () => {
            const sidebar = document.querySelector('.admin-sidebar');
            const topbar = document.querySelector('.admin-topbar');
            const content = document.querySelector('.admin-content');
            const s2 = (el) => el ? {
                bg: window.getComputedStyle(el).backgroundColor,
                color: window.getComputedStyle(el).color,
                fontSize: window.getComputedStyle(el).fontSize,
                padding: window.getComputedStyle(el).padding,
            } : null;
            return {
                sidebar: s2(sidebar),
                topbar: s2(topbar),
                content: s2(content),
                sidebarCount: document.querySelectorAll('.admin-sidebar, .sidebar').length,
                topbarCount: document.querySelectorAll('.admin-topbar, .topbar').length,
            };
        }
    """)
    print(f"Admin styles: {info}")

    browser.close()
