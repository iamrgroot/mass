<?php 

namespace App\Traits;

use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;

trait ResizedImageResponse
{
    private function resizeResponse(string $image, ?int $width = null, ?int $height = null)
    {
        return Image::make($image)
            ->resize($width, $height, function (Constraint $constraint) {
                $constraint->aspectRatio();
            })
            ->response();
    }
}