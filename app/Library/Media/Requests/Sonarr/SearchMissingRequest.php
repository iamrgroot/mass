<?php

namespace App\Library\Media\Requests\Sonarr;

class SearchMissingRequest extends CommandRequest 
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'missingEpisodeSearch',
        ]);
    }
}