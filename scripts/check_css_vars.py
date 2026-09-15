import sys
sys.stdout.reconfigure(encoding='utf-8')
from playwright.sync_api import sync_playwright

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    context = browser.new_context(viewport={"width": 1440, "height": 900})
    page = context.new_page()
    page.goto("http://127.0.0.1:8000/san-pham", wait_until="networkidle")

    info = page.evaluate("""
        () => {
            const sections = [
                '.products-grid-section',
                '.products-toolbar',
                '.products-filter-sidebar',
                '.filter-chips-section',
                '.product-card',
                'main',
            ];
            const result = {};
            for (const sel of sections) {
                const el = document.querySelector(sel);
                if (el) {
                    const s = window.getComputedStyle(el);
                    result[sel] = {
                        bg: s.backgroundColor,
                        paddingTop: s.paddingTop,
                        display: s.display,
                    };
                } else {
                    result[sel] = 'NOT FOUND';
                }
            }
            return result;
        }
    """)
    print("=== Computed styles ===")
    for sel, s in info.items():
        print(f"{sel}: {s}")

    browser.close()
