/**
 * Home Page JavaScript
 * Handles home-page animations.
 */

// Brand Values - Scroll Animation
(function initBrandValuesAnimation() {
    const brandValueItems = document.querySelectorAll('.brand-value-item');
    if (brandValueItems.length === 0) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        brandValueItems.forEach(item => item.classList.add('visible'));
        return;
    }

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('visible');
        });
    }, { threshold: 0.2, rootMargin: '0px 0px -50px 0px' });

    brandValueItems.forEach(item => observer.observe(item));
})();
