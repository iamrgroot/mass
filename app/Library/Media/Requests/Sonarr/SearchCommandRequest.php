<?php

namespace App\Library\Media\Requests\Sonarr;

class SearchCommandRequest extends CommandRequest 
{
    public function __construct(int $serie_id)
    {
        parent::__construct([
            'name' => 'SeriesSearch',
            'seriesId' => $serie_id,
        ]);
    }
}