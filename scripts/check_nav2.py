import sys
sys.stdout.reconfigure(encoding='utf-8')
from playwright.sync_api import sync_playwright

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    context = browser.new_context(viewport={"width": 1440, "height": 900})
    page = context.new_page()

    page.goto("http://127.0.0.1:8000/login", wait_until="networkidle")

    # Check navbar nav state
    info = page.evaluate("""
        () => {
            const nav = document.querySelector('.navbar-nav');
            if (!nav) return 'NO NAV';
            const s = window.getComputedStyle(nav);
            return {
                display: s.display,
                visibility: s.visibility,
                position: s.position,
                width: s.width,
                height: s.height,
                bgColor: s.backgroundColor,
                classes: [...nav.classList],
            };
        }
    """)
    print(f"Navbar nav state: {info}")

    # Check all elements with class containing 'navbar-nav'
    all_nav = page.evaluate("""
        () => {
            const els = document.querySelectorAll('[class*="navbar-nav"]');
            return [...els].map(el => ({
                tag: el.tagName,
                class: el.className.substring(0, 80),
                display: window.getComputedStyle(el).display,
            }));
        }
    """)
    print(f"All navbar-nav elements: {all_nav}")

    # Check if there's a rotated element
    transform = page.evaluate("""
        () => {
            const nav = document.querySelector('.navbar-nav');
            if (!nav) return 'no nav';
            const s = window.getComputedStyle(nav);
            return s.transform;
        }
    """)
    print(f"Nav transform: {transform}")

    # Full navbar snapshot
    nav_html = page.evaluate("() => { const n = document.querySelector('.navbar'); return n ? n.outerHTML.substring(0, 3000) : 'no navbar'; }")
    print(f"Navbar HTML: {nav_html}")

    browser.close()
