<?php

namespace App\Library\Media\DataObjects;

use App\Traits\ConvertFromObject;

class Movie extends MediaItem
{
    use ConvertFromObject;

    public string $sort_title;

    public function __construct(object $object)
    {
        $this->fromObject($object);
    }
}