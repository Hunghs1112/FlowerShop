<!-- Language Switcher — placed in navbar-actions, same row as icons -->
@php
    $currentLocale = $currentLocale ?? app()->getLocale();
    $otherLocale = $currentLocale === 'vi' ? 'en' : 'vi';
    $otherLabel = $currentLocale === 'vi' ? 'EN' : 'VI';
    $otherFlag = $currentLocale === 'vi' ? '🇬🇧' : '🇻🇳';
    $currentFlag = $currentLocale === 'vi' ? '🇻🇳' : '🇬🇧';
    $currentLabel = $currentLocale === 'vi' ? 'VI' : 'EN';
    $otherLocaleName = $currentLocale === 'vi' ? 'English' : 'Tiếng Việt';
    $currentLocaleName = $currentLocale === 'vi' ? 'Tiếng Việt' : 'English';
@endphp

<div class="lang-switcher" title="{{ $otherLocaleName }}">
    <a
        href="{{ localized_url($otherLocale) }}"
        class="lang-switcher-btn"
        rel="alternate"
        hreflang="{{ $otherLocale }}"
        aria-label="Switch to {{ $otherLocaleName }}"
    >
        <span class="lang-switcher-flag" aria-hidden="true">{{ $otherFlag }}</span>
        <span class="lang-switcher-label">{{ $otherLabel }}</span>
    </a>
</div>

<style>
/* Tối giản, hòa hợp với theme Dusty Rose */
.lang-switcher {
    display: flex;
    align-items: center;
}

.lang-switcher-btn {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 6px 10px;
    border-radius: var(--radius-md);
    font-size: 13px;
    font-weight: 500;
    color: var(--color-text-secondary);
    background: transparent;
    border: 1px solid var(--color-border);
    transition: all var(--transition-base);
    text-decoration: none;
    white-space: nowrap;
    cursor: pointer;
}

.lang-switcher-btn:hover {
    color: var(--color-accent-primary);
    border-color: var(--color-accent-primary-light);
    background: var(--color-bg-secondary);
}

.lang-switcher-flag {
    font-size: 14px;
    line-height: 1;
    opacity: 0.8;
}

.lang-switcher-label {
    font-size: 12px;
    letter-spacing: 0.03em;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .lang-switcher-btn {
        padding: 6px 8px;
        gap: 3px;
    }
}

@media (max-width: 480px) {
    .lang-switcher-label {
        display: none;
    }
    .lang-switcher-btn {
        padding: 6px;
    }
    .lang-switcher-flag {
        font-size: 16px;
    }
}
</style>
