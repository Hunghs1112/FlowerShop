<?php

// Standalone regression check: php tests/flower-atlas-check.php
require __DIR__ . '/../app/Support/FlowerAtlas.php';

use App\Support\FlowerAtlas;

function check(bool $condition, string $message): void
{
    if (!$condition) throw new RuntimeException($message);
}

function containsPoint(string $path, array $point): bool
{
    [$x, $y] = $point;
    $inside = false;
    foreach (explode('Z', $path) as $ring) {
        preg_match_all('/[ML](-?[\d.]+),(-?[\d.]+)/', $ring, $matches, PREG_SET_ORDER);
        $count = count($matches);
        for ($i = 0, $j = $count - 1; $i < $count; $j = $i++) {
            [$xi, $yi] = [(float)$matches[$i][1], (float)$matches[$i][2]];
            [$xj, $yj] = [(float)$matches[$j][1], (float)$matches[$j][2]];
            if (($yi > $y) !== ($yj > $y) && $x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi) $inside = !$inside;
        }
    }
    return $inside;
}

check(FlowerAtlas::project(0, 0) === [600.0, 280.0], 'Projection center moved');
check(FlowerAtlas::project(21.0285, 105.8542) === [915.87, 193.7], 'Hanoi projection changed');
$view = file_get_contents(__DIR__.'/../resources/views/pages/about.blade.php');
$geography = file_get_contents(__DIR__.'/../resources/views/partials/flower-atlas-geography.blade.php');
preg_match_all("/'id' => '([a-z]+)'.*?'lat' => (-?[\d.]+), 'lon' => (-?[\d.]+)/", $view, $origins, PREG_SET_ORDER);
check(count($origins) === 9, 'Expected nine source regions');
foreach ($origins as [, $id, $latitude, $longitude]) {
    $point = FlowerAtlas::project((float)$latitude, (float)$longitude);
    preg_match('/data-origin="'.$id.'"[^>]* d="([^"]+)"/', $geography, $country);
    check(isset($country[1]) && containsPoint($country[1], $point), $id.': marker outside its country');
    $route = FlowerAtlas::connection((float)$latitude, (float)$longitude);
    check(str_starts_with($route, 'M'.implode(',', $point)), $id.': route does not start at source');
    check(str_ends_with($route, 'L915.87,193.7'), $id.': route does not end at Hanoi');
    preg_match_all('/([ML])(-?[\d.]+),(-?[\d.]+)/', $route, $segments, PREG_SET_ORDER);
    $previous = null;
    foreach ($segments as [, $command, $x, $y]) {
        check($command === 'M' || $previous === null || abs((float)$x - $previous) <= 600, $id.': route crosses date line without splitting');
        $previous = (float)$x;
    }
}
echo "PASS: nine geographic markers, shared projection and date-line-safe routes.\n";
