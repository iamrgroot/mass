<?php

namespace App\Traits;

use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;

trait ResizedImageResponse
{
    private function resizeResponse(string $image, ?int $width = null, ?int $height = null)
    {
        $image = Image::make($image);

        if (null !== $height || null !== $width) {
            $image = $image->resize($width, $height, function (Constraint $constraint) {
                $constraint->aspectRatio();
            });
        }

        return $image->response();
    }
}
