import sys
sys.stdout.reconfigure(encoding='utf-8')
from playwright.sync_api import sync_playwright

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    context = browser.new_context(viewport={"width": 1440, "height": 900})
    page = context.new_page()

    page.goto("http://127.0.0.1:8000/san-pham", wait_until="networkidle", timeout=15000)

    # Scroll through the page and capture
    for name, y_offset in [
        ("hero", 0),
        ("filter", 600),
        ("grid_start", 1200),
        ("grid_middle", 2500),
        ("grid_full", 4000),
    ]:
        page.evaluate(f"window.scrollTo(0, {y_offset})")
        page.wait_for_timeout(500)
        page.screenshot(path=f"screenshots/styles_check/scroll_{name}.png")
        print(f"Captured scroll_{name}.png at y={y_offset}")

    browser.close()
