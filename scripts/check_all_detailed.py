import sys
sys.stdout.reconfigure(encoding='utf-8')
from playwright.sync_api import sync_playwright
import os

BASE_URL = "http://127.0.0.1:8000"

PAGES = [
    ("03_gio-hang", "/gio-hang"),
    ("04_danh-muc", "/danh-muc"),
    ("05_bai-viet", "/bai-viet"),
    ("06_ve-chung-toi", "/ve-chung-toi"),
    ("07_lien-he", "/lien-he"),
    ("08_login", "/login"),
    ("09_register", "/register"),
    ("10_tai-khoan", "/tai-khoan"),
]

OUT = "screenshots/styles_check"
os.makedirs(OUT, exist_ok=True)

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    context = browser.new_context(viewport={"width": 1440, "height": 900})
    page = context.new_page()

    for name, path in PAGES:
        url = BASE_URL + path
        print(f"Navigating: {url}")
        try:
            resp = page.goto(url, wait_until="networkidle", timeout=15000)
            status = resp.status if resp else "no"

            # Take viewport screenshot (no scroll)
            vp_name = os.path.join(OUT, f"{name}_vp.png")
            page.screenshot(path=vp_name)
            print(f"  Viewport saved ({status})")

            # Scroll and take full page
            page.evaluate("window.scrollTo(0, document.body.scrollHeight / 2)")
            page.wait_for_timeout(300)
            mid_name = os.path.join(OUT, f"{name}_mid.png")
            page.screenshot(path=mid_name)

            page.evaluate("window.scrollTo(0, document.body.scrollHeight)")
            page.wait_for_timeout(300)
            bot_name = os.path.join(OUT, f"{name}_bot.png")
            page.screenshot(path=bot_name)

            # Check key elements
            navbar_ok = page.locator(".navbar").count() > 0
            footer_ok = page.locator("footer, .site-footer, #footer").count() > 0
            h1_count = page.locator("h1").count()
            main_h = page.locator("main").bounding_box()["height"] if page.locator("main").count() > 0 else 0

            print(f"  navbar={navbar_ok}, footer={footer_ok}, h1={h1_count}, main_h={main_h:.0f}px")

        except Exception as e:
            print(f"  ERROR: {e}")

    browser.close()
print("\nDone.")
