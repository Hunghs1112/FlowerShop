import sys
sys.stdout.reconfigure(encoding='utf-8')
from playwright.sync_api import sync_playwright
import os

BASE_URL = "http://127.0.0.1:8000"
OUT = "screenshots/styles_check"
os.makedirs(OUT, exist_ok=True)

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    context = browser.new_context(viewport={"width": 1440, "height": 900})
    page = context.new_page()

    # Products page - scroll to show grid
    page.goto(BASE_URL + "/san-pham", wait_until="networkidle")
    page.evaluate("window.scrollTo(0, 800)")
    page.wait_for_timeout(500)
    page.screenshot(path=os.path.join(OUT, "products_filter_visible.png"))
    page.evaluate("window.scrollTo(0, 1400)")
    page.wait_for_timeout(500)
    page.screenshot(path=os.path.join(OUT, "products_grid_visible.png"))

    # Home page
    page.goto(BASE_URL + "/", wait_until="networkidle")
    page.screenshot(path=os.path.join(OUT, "home_final.png"), full_page=True)

    # Login page
    page.goto(BASE_URL + "/login", wait_until="networkidle")
    page.screenshot(path=os.path.join(OUT, "login_final.png"), full_page=True)

    # Blog
    page.goto(BASE_URL + "/bai-viet", wait_until="networkidle")
    page.screenshot(path=os.path.join(OUT, "blog_final.png"), full_page=True)

    # Gio hang
    page.goto(BASE_URL + "/gio-hang", wait_until="networkidle")
    page.screenshot(path=os.path.join(OUT, "cart_final.png"), full_page=True)

    print("All final screenshots saved.")
    browser.close()
