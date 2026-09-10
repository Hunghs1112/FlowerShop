<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Supported locales for the application.
     */
    protected array $supportedLocales = ['vi', 'en'];

    /**
     * Handle an incoming request.
     *
     * Priority:
     *  1. URL locale prefix (vi/en)           - highest priority
     *  2. Session locale                     - user previously selected
     *  3. Browser Accept-Language header     - auto-detect
     *  4. Fallback → 'vi'                    - default
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->resolveLocale($request);

        app()->setLocale($locale);

        return $next($request);
    }

    /**
     * Resolve the best locale for the current request.
     */
    protected function resolveLocale(Request $request): string
    {
        // 1. URL locale prefix (e.g. /vi/san-pham → 'vi')
        $urlLocale = $request->segment(1);
        if ($urlLocale && in_array($urlLocale, $this->supportedLocales, true)) {
            $this->storeLocale($urlLocale);
            return $urlLocale;
        }

        // 2. Session locale (user previously selected)
        $sessionLocale = Session::get('locale');
        if ($sessionLocale && in_array($sessionLocale, $this->supportedLocales, true)) {
            return $sessionLocale;
        }

        // 3. Browser Accept-Language header
        $browserLocale = $request->getPreferredLanguage($this->supportedLocales);
        if ($browserLocale && in_array($browserLocale, $this->supportedLocales, true)) {
            return $browserLocale;
        }

        // 4. Fallback
        return 'vi';
    }

    /**
     * Store locale in session (fast, no DB call needed).
     */
    protected function storeLocale(string $locale): void
    {
        Session::put('locale', $locale);
    }
}
