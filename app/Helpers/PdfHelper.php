<?php

namespace App\Helpers;

use setasign\Fpdi\Fpdi;

class PdfHelper
{
    public static function getPagesCount(string $path)
    {
        $pdf = new Fpdi();
//        $pdf->setSourceFile($path);
        return $pdf->setSourceFile($path);
    }
}
