<?php

namespace App\Library\Media\Requests\Sonarr;

class RefreshRequest extends CommandRequest 
{
    public function __construct(int $serie_id)
    {
        parent::__construct([
            'name' => 'RefreshSeries',
            'seriesId' => $serie_id,
        ]);
    }
}