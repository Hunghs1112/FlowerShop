{{-- Language Switcher Component - 显示当前语言和切换选项 --}}
@php
    $currentLocale = app()->getLocale();
    $otherLocale = $currentLocale === 'vi' ? 'en' : 'vi';
    $flags = ['vi' => '🇻🇳', 'en' => '🇬🇧'];
    $labels = ['vi' => 'VI', 'en' => 'EN'];
    $names = ['vi' => 'Tiếng Việt', 'en' => 'English'];
@endphp

<div class="lang-switcher" title="Switch to {{ $names[$otherLocale] }}">
    <button type="button" class="lang-switcher-current">
        <span class="lang-switcher-flag" aria-hidden="true">{{ $flags[$currentLocale] }}</span>
        <span class="lang-switcher-label">{{ $labels[$currentLocale] }}</span>
    </button>
    <span class="lang-switcher-divider">|</span>
    <a
        href="{{ localized_url($otherLocale) }}"
        class="lang-switcher-link"
        rel="alternate"
        hreflang="{{ $otherLocale }}"
        aria-label="Switch to {{ $names[$otherLocale] }}"
    >
        <span class="lang-switcher-flag" aria-hidden="true">{{ $flags[$otherLocale] }}</span>
        <span class="lang-switcher-label">{{ $labels[$otherLocale] }}</span>
    </a>
</div>

<style>
/* Language Switcher Styles */
.lang-switcher {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    border-radius: var(--radius-md);
    border: 1px solid var(--color-border);
    background: transparent;
}

.lang-switcher-current,
.lang-switcher-link {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 4px 6px;
    border-radius: var(--radius-sm);
    font-size: 13px;
    font-weight: 500;
    transition: all var(--transition-base);
    text-decoration: none;
    white-space: nowrap;
    cursor: pointer;
    border: none;
    background: transparent;
}

.lang-switcher-current {
    color: var(--color-accent-primary);
    font-weight: 600;
    cursor: default;
}

.lang-switcher-link {
    color: var(--color-text-secondary);
    opacity: 0.6;
}

.lang-switcher-link:hover {
    color: var(--color-accent-primary);
    opacity: 1;
    background: var(--color-bg-secondary);
}

.lang-switcher-divider {
    color: var(--color-border);
    font-size: 12px;
    opacity: 0.5;
}

.lang-switcher-flag {
    font-size: 14px;
    line-height: 1;
}

.lang-switcher-label {
    font-size: 12px;
    letter-spacing: 0.03em;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .lang-switcher {
        padding: 3px 6px;
        gap: 3px;
    }
    
    .lang-switcher-current,
    .lang-switcher-link {
        padding: 3px 4px;
    }
}

@media (max-width: 480px) {
    .lang-switcher-label {
        display: none;
    }
    
    .lang-switcher-flag {
        font-size: 16px;
    }
}
</style>
