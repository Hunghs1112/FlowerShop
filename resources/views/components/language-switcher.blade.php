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
.lang-switcher {
    display: flex;
    align-items: center;
}

.lang-switcher-btn {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.85);
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.2s ease;
    text-decoration: none;
    white-space: nowrap;
    cursor: pointer;
}

.lang-switcher-btn:hover {
    background: rgba(255, 255, 255, 0.22);
    color: #fff;
    border-color: rgba(255, 255, 255, 0.4);
}

.lang-switcher-flag {
    font-size: 14px;
    line-height: 1;
}

.lang-switcher-label {
    font-size: 12px;
    letter-spacing: 0.5px;
}

/* Mobile responsive */
@media (max-width: 480px) {
    .lang-switcher-label {
        display: none;
    }
    .lang-switcher-btn {
        padding: 6px 8px;
    }
}
</style>
