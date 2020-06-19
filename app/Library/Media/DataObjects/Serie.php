<?php

namespace App\Library\Media\DataObjects;

use App\Traits\ConvertFromObject;

class Serie extends MediaItem
{
    use ConvertFromObject;

    public array $seasons;

    public function __construct(object $object)
    {
        $this->fromObject($object);
    }
}