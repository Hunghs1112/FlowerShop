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

    # Track CSS failures
    failed_css = []
    def on_css_fail(response):
        if response.status >= 400 and '.css' in response.url:
            failed_css.append(f"HTTP {response.status}: {response.url}")
    page.on("response", on_css_fail)

    pages = [
        ("home_fixed", "/"),
        ("san-pham_fixed", "/san-pham"),
        ("gio-hang_fixed", "/gio-hang"),
        ("danh-muc_fixed", "/danh-muc"),
        ("bai-viet_fixed", "/bai-viet"),
        ("ve-chung-toi_fixed", "/ve-chung-toi"),
        ("lien-he_fixed", "/lien-he"),
        ("login_fixed", "/login"),
    ]

    for name, path in pages:
        failed_css.clear()
        page.goto(BASE_URL + path, wait_until="networkidle", timeout=15000)
        page.screenshot(path=os.path.join(OUT, f"{name}.png"), full_page=True)
        print(f"{name}: {len(failed_css)} CSS errors", end="")
        if failed_css:
            print(f" -> {failed_css[:2]}")
        else:
            print()

    browser.close()
print("Done.")
