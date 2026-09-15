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

    # Get first product slug
    page.goto(BASE_URL + "/san-pham", wait_until="networkidle")
    first_link = page.locator(".product-card a.product-card__full-link").first
    href = first_link.get_attribute("href")
    slug = href.split("/")[-1] if href else "hoa-hong-do"
    print(f"First product: {slug}")

    # Visit product detail
    page.goto(f"{BASE_URL}/san-pham/{slug}", wait_until="networkidle")
    page.screenshot(path=os.path.join(OUT, "product_detail_fixed.png"), full_page=True)
    print("Product detail saved")

    # Check CSS loaded
    failed = []
    def on_fail(response):
        if response.status >= 400 and '.css' in response.url:
            failed.append(response.url)
    page.on("response", on_fail)

    # Reload
    page.goto(f"{BASE_URL}/san-pham/{slug}", wait_until="networkidle")
    print(f"CSS failures: {failed}")

    # Check element styles
    styles = page.evaluate("""
        () => {
            const gallery = document.querySelector('.product-gallery');
            const info = document.querySelector('.product-info');
            const desc = document.querySelector('.product-description');
            const related = document.querySelector('.related-products');
            const s2 = (el) => el ? {
                bg: window.getComputedStyle(el).backgroundColor,
                padding: window.getComputedStyle(el).paddingTop,
                display: window.getComputedStyle(el).display,
            } : null;
            return {
                gallery: s2(gallery),
                info: s2(info),
                desc: s2(desc),
                related: s2(related),
            };
        }
    """)
    print(f"Product detail styles: {styles}")

    browser.close()
