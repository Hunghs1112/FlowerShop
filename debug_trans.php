<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
echo "Locale: " . app()->getLocale() . "\n";
echo "Fallback: " . config('app.fallback_locale') . "\n";
echo "Home: " . __('messages.nav.home') . "\n";
echo "Products: " . __('messages.nav.products') . "\n";
echo "Cart: " . __('messages.nav.cart') . "\n";
