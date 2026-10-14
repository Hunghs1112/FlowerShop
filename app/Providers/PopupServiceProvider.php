<?php

namespace App\Providers;

use App\Models\Popup;
use Illuminate\Support\ServiceProvider;

class PopupServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Share popup config to all views
        view()->composer('layouts.app', function ($view) {
            $popups = Popup::current()->sorted()->get();
            $config = [
                'delay' => 4,
                'frequency' => 'day',
                'zalo' => '0869308993',
                'campaigns' => $popups->map(fn($p) => $p->toLntConfig())->values()->all(),
            ];
            $view->with('popupConfig', json_encode(
                $config,
                JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
            ));
        });
    }
}
