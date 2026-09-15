import sys
sys.stdout.reconfigure(encoding='utf-8')
from playwright.sync_api import sync_playwright

with sync_playwright() as p:
    browser = p.chromium.launch(headless=True)
    context = browser.new_context(viewport={"width": 1440, "height": 900})
    page = context.new_page()

    page.goto("http://127.0.0.1:8000/bai-viet", wait_until="networkidle", timeout=15000)

    # Get layout structure
    info = page.evaluate("""
        () => {
            const main = document.querySelector('main');
            const container = document.querySelector('.page-wrapper');
            const blogGrid = document.querySelector('.blog-grid');
            const pageHero = document.querySelector('.page-hero');

            const getStyles = (el) => {
                if (!el) return null;
                const s = window.getComputedStyle(el);
                return {
                    width: s.width,
                    maxWidth: s.maxWidth,
                    margin: s.margin,
                    padding: s.padding,
                    display: s.display,
                    bgColor: s.backgroundColor,
                };
            };

            return {
                main: getStyles(main),
                container: getStyles(container),
                blogGrid: getStyles(blogGrid),
                pageHero: getStyles(pageHero),
                // Count elements
                postCards: document.querySelectorAll('.post-card').length,
                navbarHeight: document.querySelector('.navbar')?.offsetHeight,
            };
        }
    """)

    print("=== Blog Page Layout ===")
    for key, val in info.items():
        print(f"{key}: {val}")

    # Also check page-hero specifically
    hero = page.locator(".page-hero")
    if hero.count() > 0:
        print(f"\nPage hero bounding box: {hero.bounding_box()}")

    # Check the .page-wrapper
    wrapper = page.locator(".page-wrapper")
    if wrapper.count() > 0:
        print(f"Page-wrapper bounding box: {wrapper.bounding_box()}")
        styles = page.evaluate("""
            () => {
                const w = document.querySelector('.page-wrapper');
                const s = window.getComputedStyle(w);
                return {
                    display: s.display,
                    maxWidth: s.maxWidth,
                    marginLeft: s.marginLeft,
                    marginRight: s.marginRight,
                    paddingLeft: s.paddingLeft,
                    paddingRight: s.paddingRight,
                    width: s.width,
                };
            }
        """)
        print(f"Page-wrapper styles: {styles}")

    # Check body width
    body_styles = page.evaluate("""
        () => {
            const body = document.body;
            const s = window.getComputedStyle(body);
            return { width: s.width, bg: s.backgroundColor, margin: s.margin };
        }
    """)
    print(f"\nBody: {body_styles}")

    browser.close()
