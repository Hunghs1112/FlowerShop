<?php

namespace App\Support;

/** Equal Earth projection shared by the geographic outlines and the origin markers. */
final class FlowerAtlas
{
    public static function project(float $latitude, float $longitude): array
    {
        // https://github.com/d3/d3-geo/blob/main/src/projection/equalEarth.js
        $m = sqrt(3) / 2;
        $theta = asin($m * sin(deg2rad($latitude)));
        $theta2 = $theta * $theta;
        $theta6 = $theta2 * $theta2 * $theta2;
        $x = deg2rad($longitude) * cos($theta)
            / ($m * (1.340264 - 3 * .081106 * $theta2 + $theta6 * (7 * .000893 + 9 * .003796 * $theta2)));
        $y = $theta * (1.340264 - .081106 * $theta2 + $theta6 * (.000893 + .003796 * $theta2));

        return [round(600 + 205 * $x, 2), round(280 - 205 * $y, 2)];
    }

    public static function connection(float $latitude, float $longitude): string
    {
        $start = self::vector($latitude, $longitude);
        $end = self::vector(21.0285, 105.8542);
        $angle = acos(max(-1, min(1, array_sum(array_map(fn ($a, $b) => $a * $b, $start, $end)))));
        $path = [];
        $previousX = null;

        for ($step = 0; $step <= 32; $step++) {
            $t = $step / 32;
            $a = $angle < .000001 ? 1 - $t : sin((1 - $t) * $angle) / sin($angle);
            $b = $angle < .000001 ? $t : sin($t * $angle) / sin($angle);
            [$x, $y, $z] = array_map(fn ($s, $e) => $a * $s + $b * $e, $start, $end);
            [$mapX, $mapY] = self::project(rad2deg(atan2($z, hypot($x, $y))), rad2deg(atan2($y, $x)));
            // Split at the date line instead of drawing a line across the whole map.
            $path[] = ($previousX === null || abs($mapX - $previousX) > 600 ? 'M' : 'L') . $mapX . ',' . $mapY;
            $previousX = $mapX;
        }

        return implode(' ', $path);
    }

    private static function vector(float $latitude, float $longitude): array
    {
        $lat = deg2rad($latitude);
        $lon = deg2rad($longitude);

        return [cos($lat) * cos($lon), cos($lat) * sin($lon), sin($lat)];
    }
}
