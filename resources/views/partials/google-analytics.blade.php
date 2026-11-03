@if (!empty($siteSettings['google_analytics']))
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ urlencode($siteSettings['google_analytics']) }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', @json($siteSettings['google_analytics']));
    </script>
@endif
