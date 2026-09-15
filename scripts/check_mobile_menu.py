import sys
sys.stdout.reconfigure(encoding='utf-8')
from playwright.sync_api import sync_playwright

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    context = browser.new_context(viewport={"width": 1440, "height": 900})
    page = context.new_page()

    page.goto("http://127.0.0.1:8000/login", wait_until="networkidle")

    # Check mobile menu visibility
    mobile_menu = page.locator(".navbar-mobile-menu")
    if mobile_menu.count() > 0:
        display = page.evaluate("() => getComputedStyle(document.querySelector('.navbar-mobile-menu')).display")
        visibility = page.evaluate("() => getComputedStyle(document.querySelector('.navbar-mobile-menu')).visibility")
        opacity = page.evaluate("() => getComputedStyle(document.querySelector('.navbar-mobile-menu')).opacity")
        z = page.evaluate("() => getComputedStyle(document.querySelector('.navbar-mobile-menu')).zIndex")
        print(f"Mobile menu: display={display}, visibility={visibility}, opacity={opacity}, zIndex={z}")

    # Check what's at position 0,0 (where menu seems to be)
    menu_at_top = page.evaluate("""
        () => {
            const el = document.elementFromPoint(200, 200);
            if (el) {
                return {
                    tag: el.tagName,
                    class: el.className,
                    id: el.id,
                    parent: el.parentElement?.className,
                    zIndex: window.getComputedStyle(el).zIndex,
                };
            }
        }
    """)
    print(f"Element at 200,200: {menu_at_top}")

    # Check all children of navbar
    nav_html = page.evaluate("() => document.querySelector('.navbar')?.outerHTML?.substring(0, 2000)")
    print(f"Navbar HTML snippet: {nav_html}")

    browser.close()
