<?php

namespace App\Library\Media\Requests\Radarr;

class SearchCommandRequest extends CommandRequest
{
    public function __construct(int $movie_id)
    {
        parent::__construct([
            'name'     => 'MoviesSearch',
            'movieIds' => [$movie_id],
        ]);
    }
}
