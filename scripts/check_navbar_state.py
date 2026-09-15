import sys
sys.stdout.reconfigure(encoding='utf-8')
from playwright.sync_api import sync_playwright

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    context = browser.new_context(viewport={"width": 1440, "height": 900})
    page = context.new_page()

    page.goto("http://127.0.0.1:8000/login", wait_until="networkidle")

    # Check mobile menu state
    info = page.evaluate("""
        () => {
            const menu = document.querySelector('.navbar-mobile-menu');
            if (!menu) return 'NO MENU';
            const s = window.getComputedStyle(menu);
            return {
                classes: [...menu.classList],
                display: s.display,
                visibility: s.visibility,
                opacity: s.opacity,
                zIndex: s.zIndex,
                position: s.position,
                top: s.top,
            };
        }
    """)
    print(f"Mobile menu state: {info}")

    # Check what's at left side
    overlay = page.evaluate("""
        () => {
            const el = document.elementFromPoint(50, 150);
            if (!el) return 'null';
            let curr = el;
            let path = [];
            while (curr && path.length < 5) {
                path.push(curr.tagName + '.' + curr.className.substring(0, 50));
                curr = curr.parentElement;
            }
            return path;
        }
    """)
    print(f"Elements at 50,150: {overlay}")

    browser.close()
