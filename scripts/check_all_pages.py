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
    ("10_checkout", "/thanh-toan"),
    ("11_tai-khoan", "/tai-khoan"),
]

OUT = "screenshots/styles_check"
os.makedirs(OUT, exist_ok=True)

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    context = browser.new_context(viewport={"width": 1280, "height": 900})
    page = context.new_page()

    errors = []
    def on_console(msg):
        if msg.type == "error":
            errors.append(f"[{msg.type}] {msg.text}")
    page.on("console", on_console)

    for name, path in PAGES:
        url = BASE_URL + path
        print(f"\n=== {name}: {url} ===")
        try:
            resp = page.goto(url, wait_until="networkidle", timeout=15000)
            status = resp.status if resp else "no"
            print(f"Status: {status}")

            fname = os.path.join(OUT, f"{name}.png")
            page.screenshot(path=fname, full_page=True)
            print(f"Saved: {fname}")

            h1s = page.locator("h1").all()
            h2s = page.locator("h2").all()
            body_text = page.locator("body").inner_text()
            print(f"h1={len(h1s)}, h2={len(h2s)}, chars={len(body_text.strip())}")

            # Check if page content looks like actual page or error/redirect
            if status >= 400:
                print(f"  WARNING: HTTP {status}")
            if len(body_text.strip()) < 100:
                print(f"  WARNING: Very little content ({len(body_text.strip())} chars)")

        except Exception as e:
            print(f"ERROR: {e}")
            try:
                page.screenshot(path=os.path.join(OUT, f"{name}_error.png"), full_page=True)
            except:
                pass

    print("\n=== Console Errors ===")
    for e in errors:
        print(e)

    browser.close()

print(f"\nDone. Screenshots in: {OUT}/")
