<?php

namespace App\Library\Media\DataObjects;

use App\Traits\ConvertFromObject;

class Season
{
    use ConvertFromObject;

    public int $season_number;
    public bool $monitored;

    public function __construct(object $season)
    {
        $this->fromObject($season);
    }
}
