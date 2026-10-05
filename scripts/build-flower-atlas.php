<?php

// Generates the committed SVG geography. No download or projection runs in the browser.
require __DIR__ . '/../app/Support/FlowerAtlas.php';

use App\Support\FlowerAtlas;

$source = 'https://raw.githubusercontent.com/nvkelso/natural-earth-vector/v5.1.2/geojson/';
$output = '<!-- Generated with Natural Earth 1:50m (public domain), Equal Earth projection. -->' . PHP_EOL;
$origins = ['CN', 'NL', 'EC', 'ZA', 'JP', 'MY', 'VN', 'CO', 'NZ'];
$vertices = 0;

// Discard sub-pixel detail while keeping the actual coastline and small islands.
function simplifyRing(array $points): array
{
    if (count($points) < 3) {
        return $points;
    }
    [$ax, $ay] = $points[0];
    [$bx, $by] = $points[array_key_last($points)];
    $length = hypot($bx - $ax, $by - $ay);
    $furthest = 0;
    $distance = 0;
    foreach (array_slice($points, 1, -1, true) as $index => [$x, $y]) {
        $candidate = $length === 0.0 ? hypot($x - $ax, $y - $ay)
            : abs(($by - $ay) * $x - ($bx - $ax) * $y + $bx * $ay - $by * $ax) / $length;
        if ($candidate > $distance) {
            $distance = $candidate;
            $furthest = $index;
        }
    }
    if ($distance <= .16) {
        return [$points[0], $points[array_key_last($points)]];
    }
    return array_merge(array_slice(simplifyRing(array_slice($points, 0, $furthest + 1)), 0, -1), simplifyRing(array_slice($points, $furthest)));
}

$output .= '<g class="atlas-graticule" aria-hidden="true">' . PHP_EOL;
foreach (range(-150, 150, 30) as $lon) {
    $points = array_map(fn ($lat) => implode(',', FlowerAtlas::project($lat, $lon)), range(-60, 84, 2));
    $output .= '    <path d="M' . implode('L', $points) . '" />' . PHP_EOL;
}
foreach (range(-60, 60, 30) as $lat) {
    $points = array_map(fn ($lon) => implode(',', FlowerAtlas::project($lat, $lon)), range(-180, 180, 2));
    $output .= '    <path d="M' . implode('L', $points) . '" />' . PHP_EOL;
}
$output .= '</g>' . PHP_EOL;

foreach (['countries' => 'ne_50m_admin_0_countries.geojson', 'lakes' => 'ne_50m_lakes.geojson'] as $layer => $file) {
    $data = json_decode(file_get_contents($source . $file), true, 512, JSON_THROW_ON_ERROR);
    $output .= '<g class="atlas-' . $layer . '" aria-hidden="true">' . PHP_EOL;

    foreach ($data['features'] as $feature) {
        $properties = $feature['properties'];
        $code = $properties['ISO_A2_EH'] ?? $properties['ISO_A2'] ?? '';
        if ($code === 'AQ' || ($properties['ADMIN'] ?? '') === 'Antarctica') {
            continue;
        }
        $polygons = $feature['geometry']['type'] === 'Polygon'
            ? [$feature['geometry']['coordinates']] : $feature['geometry']['coordinates'];
        $paths = [];
        foreach ($polygons as $polygon) {
            foreach ($polygon as $ring) {
                $points = [];
                foreach ($ring as [$longitude, $latitude]) {
                    [$x, $y] = FlowerAtlas::project($latitude, $longitude);
                    if ([$x, $y] !== end($points)) {
                        $points[] = [$x, $y];
                    }
                }
                $points = simplifyRing($points);
                if (count($points) >= 3) {
                    $paths[] = 'M' . implode('L', array_map(fn ($point) => implode(',', $point), $points)) . 'Z';
                    $vertices += count($points);
                }
            }
        }
        $origin = in_array($code, $origins, true) ? ' data-origin="' . strtolower($code) . '"' : '';
        $output .= '    <path' . $origin . ' fill-rule="evenodd" d="' . implode(' ', $paths) . '" />' . PHP_EOL;
    }
    $output .= '</g>' . PHP_EOL;
}

file_put_contents(__DIR__ . '/../resources/views/partials/flower-atlas-geography.blade.php', $output);
printf("Generated %s vertices; %.0f KB of SVG geography.\n", number_format($vertices), strlen($output) / 1024);
