from playwright.sync_api import sync_playwright
import os

BASE_URL = "http://127.0.0.1:8000"

PAGES = [
    ("01_home", "/"),
    ("02_san-pham", "/san-pham"),
    ("03_gio-hang", "/gio-hang"),
    ("04_danh-muc", "/danh-muc"),
    ("05_bai-viet", "/bai-viet"),
    ("06_ve-chung-toi", "/ve-chung-toi"),
    ("07_lien-he", "/lien-he"),
    ("08_login", "/login"),
    ("09_register", "/register"),
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
        page.goto(url, wait_until="networkidle", timeout=15000)

        fname = os.path.join(OUT, f"{name}_full.png")
        page.screenshot(path=fname, full_page=True)
        print(f"  Saved: {fname}")

    browser.close()

print("Done.")
