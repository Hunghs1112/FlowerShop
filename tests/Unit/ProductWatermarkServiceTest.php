<?php

namespace Tests\Unit;

use App\Services\ProductWatermarkService;
use PHPUnit\Framework\TestCase;

class ProductWatermarkServiceTest extends TestCase
{
    public function test_it_bakes_the_configured_watermark_into_the_downloaded_image(): void
    {
        $image = imagecreatetruecolor(100, 100);
        imagefill($image, 0, 0, imagecolorallocate($image, 255, 255, 255));
        $logo = imagecreatetruecolor(10, 10);
        imagealphablending($logo, false);
        imagesavealpha($logo, true);
        imagefill($logo, 0, 0, imagecolorallocatealpha($logo, 0, 0, 0, 127));
        imagefilledrectangle($logo, 2, 2, 7, 7, imagecolorallocate($logo, 0, 0, 0));

        ob_start();
        imagepng($image);
        $imageContents = ob_get_clean();
        ob_start();
        imagepng($logo);
        $logoContents = ob_get_clean();
        imagedestroy($image);
        imagedestroy($logo);

        $result = (new ProductWatermarkService)->render($imageContents, $logoContents, [
            'variant' => 'brown',
            'position' => 'br',
            'size' => 20,
            'margin' => 0,
            'opacity' => 100,
        ]);

        $rendered = imagecreatefromstring($result['contents']);
        $pixel = imagecolorat($rendered, 90, 90);
        $transparentPixel = imagecolorat($rendered, 81, 81);

        $this->assertSame('image/png', $result['mime']);
        $this->assertSame([74, 56, 38], [($pixel >> 16) & 0xFF, ($pixel >> 8) & 0xFF, $pixel & 0xFF]);
        $this->assertSame([255, 255, 255], [($transparentPixel >> 16) & 0xFF, ($transparentPixel >> 8) & 0xFF, $transparentPixel & 0xFF]);

        imagedestroy($rendered);
    }
}
