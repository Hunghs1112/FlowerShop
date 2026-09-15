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
    page.fill("input[name='email']", "admin@lamnhienthao.vn")
    page.fill("input[name='password']", "password")
    page.click("button[type='submit']")
    page.wait_for_load_state("networkidle")
    print("Logged in as admin")

    # Admin dashboard
    page.goto("http://127.0.0.1:8000/admin", wait_until="networkidle")
    page.screenshot(path="screenshots/styles_check/admin_dashboard_full.png", full_page=True)

    # Check sidebar/topbar
    sidebar_count = page.locator("[class*='sidebar'], [id*='sidebar']").count()
    topbar_count = page.locator("[class*='topbar'], [id*='topbar']").count()
    nav_count = page.locator("nav").count()
    body_text = page.locator("body").inner_text()[:300]
    print(f"sidebar elements: {sidebar_count}, topbar: {topbar_count}, nav: {nav_count}")
    print(f"Body text: {body_text}")

    # Admin products
    page.goto("http://127.0.0.1:8000/admin/products", wait_until="networkidle")
    page.screenshot(path="screenshots/styles_check/admin_products_full.png", full_page=True)
    print("Admin products saved")

    browser.close()
