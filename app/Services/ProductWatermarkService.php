<?php

namespace App\Services;

use RuntimeException;

class ProductWatermarkService
{
    /** @return array{contents: string, mime: string, extension: string} */
    public function render(string $imageContents, string $logoContents, array $settings): array
    {
        $imageInfo = getimagesizefromstring($imageContents);
        $image = @imagecreatefromstring($imageContents);
        $logo = @imagecreatefromstring($logoContents);

        if ($imageInfo === false || $image === false || $logo === false) {
            throw new RuntimeException('Không thể đọc ảnh hoặc logo watermark.');
        }

        try {
            $width = imagesx($image);
            $height = imagesy($image);
            $base = min($width, $height);
            $logoWidth = max(1, (int) round($base * $settings['size'] / 100));
            $logoHeight = max(1, (int) round($logoWidth * imagesy($logo) / imagesx($logo)));
            $watermark = imagescale($logo, $logoWidth, $logoHeight, IMG_BICUBIC_FIXED);

            if ($watermark === false) {
                throw new RuntimeException('Không thể thay đổi kích thước logo watermark.');
            }

            try {
                $this->colorizeAndFade($watermark, $settings['variant'], $settings['opacity']);
                imagealphablending($image, true);

                $margin = $base * $settings['margin'] / 100;
                $column = $settings['position'][1];
                $row = $settings['position'][0];
                $left = (int) round($column === 'l' ? $margin : ($column === 'c' ? ($width - $logoWidth) / 2 : $width - $logoWidth - $margin));
                $top = (int) round($row === 't' ? $margin : ($row === 'm' ? ($height - $logoHeight) / 2 : $height - $logoHeight - $margin));

                imagecopy($image, $watermark, $left, $top, 0, 0, $logoWidth, $logoHeight);
            } finally {
                imagedestroy($watermark);
            }

            ob_start();
            $mime = $imageInfo['mime'];
            imagesavealpha($image, true);
            if ($mime === 'image/jpeg') {
                $extension = 'jpg';
                imagejpeg($image, null, 92);
            } elseif ($mime === 'image/webp') {
                $extension = 'webp';
                imagewebp($image, null, 90);
            } else {
                // shortcut: animated GIFs become a PNG of the first frame; use an animation library if animated product photos are required.
                $extension = 'png';
                imagepng($image, null, 6);
            }
            $contents = ob_get_clean();

            return [
                'contents' => $contents,
                'mime' => $extension === 'jpg' ? 'image/jpeg' : "image/{$extension}",
                'extension' => $extension,
            ];
        } finally {
            imagedestroy($image);
            imagedestroy($logo);
        }
    }

    private function colorizeAndFade(\GdImage $image, string $variant, int $opacity): void
    {
        imagealphablending($image, false);
        imagesavealpha($image, true);
        $color = [
            'white' => [255, 255, 255],
            'brown' => [74, 56, 38],
            'cream' => [244, 232, 220],
        ][$variant] ?? null;
        $opacity /= 100;

        for ($y = 0; $y < imagesy($image); $y++) {
            for ($x = 0; $x < imagesx($image); $x++) {
                $rgba = imagecolorat($image, $x, $y);
                $alpha = ($rgba >> 24) & 0x7F;
                $alpha = 127 - (int) round((127 - $alpha) * $opacity);
                $red = $color[0] ?? (($rgba >> 16) & 0xFF);
                $green = $color[1] ?? (($rgba >> 8) & 0xFF);
                $blue = $color[2] ?? ($rgba & 0xFF);
                imagesetpixel($image, $x, $y, ($alpha << 24) | ($red << 16) | ($green << 8) | $blue);
            }
        }
    }
}
