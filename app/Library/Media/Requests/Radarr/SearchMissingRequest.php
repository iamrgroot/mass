<?php

namespace App\Library\Media\Requests\Radarr;

class SearchMissingRequest extends CommandRequest
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'missingMoviesSearch',
        ]);
    }
}
