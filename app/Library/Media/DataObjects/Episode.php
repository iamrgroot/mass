<?php

namespace App\Library\Media\DataObjects;

use App\Traits\ConvertFromObject;

class Episode
{
    use ConvertFromObject;

    public int $id;
    public int $season_number;
    public int $episode_number;

    public function __construct(object $object)
    {
        $this->fromObject($object);
    }
}
