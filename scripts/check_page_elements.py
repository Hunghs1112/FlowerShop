import sys
sys.stdout.reconfigure(encoding='utf-8')
from playwright.sync_api import sync_playwright

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

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    # Larger viewport
    context = browser.new_context(viewport={"width": 1440, "height": 2000})
    page = context.new_page()

    for name, path in PAGES:
        url = BASE_URL + path
        page.goto(url, wait_until="networkidle", timeout=15000)

        # Check key indicators
        body = page.locator("body")
        style = body.evaluate("el => window.getComputedStyle(el).fontFamily")
        main_h = page.locator("main").bounding_box()["height"]

        # Check navbar visible
        navbar = page.locator(".navbar, #navbar, nav")
        navbar_visible = navbar.count() > 0 and navbar.first.is_visible()

        # Check footer visible
        footer = page.locator("footer, .footer")
        footer_visible = footer.count() > 0 and footer.first.is_visible()

        # Count elements
        h1s = page.locator("h1").count()
        articles = page.locator("article, .product-card").count()
        buttons = page.locator("button").count()

        # Check bg color
        bg_color = page.evaluate("() => getComputedStyle(document.body).backgroundColor")

        print(f"{name}: main_h={main_h}, h1={h1s}, articles={articles}, buttons={buttons}, bg={bg_color}, navbar={navbar_visible}, footer={footer_visible}")

    browser.close()
