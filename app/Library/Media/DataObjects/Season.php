<?php

namespace App\Library\Media\DataObjects;

use App\Traits\ConvertFromObject;
use Illuminate\Support\Collection;

class Season
{
    use ConvertFromObject;

    public int $season_number;
    public bool $monitored;

    public Collection $episodes;

    public function __construct(object $season, Collection $episodes)
    {
        $this->fromObject($season);

        $this->episodes = $episodes;
    }
}
