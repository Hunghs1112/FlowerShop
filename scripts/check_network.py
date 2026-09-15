from playwright.sync_api import sync_playwright
import os

BASE_URL = "http://127.0.0.1:8000"

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    context = browser.new_context(viewport={"width": 1280, "height": 900})
    page = context.new_page()

    failed = []
    def on_request_failed(request):
        failed.append(f"FAIL: {request.url} — {request.failure}")

    def on_response(response):
        if response.status >= 400:
            failed.append(f"HTTP {response.status}: {response.url}")

    page.on("requestfailed", on_request_failed)
    page.on("response", on_response)

    # Test each page
    for name, path in [
        ("01_home", "/"),
        ("02_san-pham", "/san-pham"),
        ("03_gio-hang", "/gio-hang"),
        ("04_danh-muc", "/danh-muc"),
        ("05_bai-viet", "/bai-viet"),
        ("06_ve-chung-toi", "/ve-chung-toi"),
        ("07_lien-he", "/lien-he"),
        ("08_login", "/login"),
        ("09_register", "/register"),
    ]:
        url = BASE_URL + path
        print(f"\n=== {name} ===")
        failed.clear()
        page.goto(url, wait_until="networkidle", timeout=15000)
        if failed:
            for f in failed:
                print(f"  {f}")
        else:
            print("  OK - no failures")

    browser.close()
