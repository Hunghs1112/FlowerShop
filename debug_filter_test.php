<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$ps = new App\Services\ProductService();
$products = $ps->filterProducts(['sort_by' => 'latest', 'per_page' => 12]);

echo "Total: " . $products->total() . "\n";
echo "Count: " . $products->count() . "\n";
echo "First: " . ($products->first()->name ?? 'NONE') . "\n";
