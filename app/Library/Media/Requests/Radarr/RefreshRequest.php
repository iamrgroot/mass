<?php

namespace App\Library\Media\Requests\Radarr;

class RefreshRequest extends CommandRequest 
{
    public function __construct(int $movie_id)
    {
        parent::__construct([
            'name' => 'RefreshMovie',
            'movieId' => $movie_id,
        ]);
    }
}