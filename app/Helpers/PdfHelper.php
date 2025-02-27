<?php

namespace App\Helpers;

use Imagick;
use ImagickException;

class PdfHelper
{
    /**
     * @throws ImagickException
     */
    public static function getPagesCount(string $path)
    {
        $image = new Imagick();
        $image->pingImage($path);

        return $image->getNumberImages();
    }
}
