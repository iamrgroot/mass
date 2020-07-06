<?php

namespace App\Library\Media\Responses\Radarr;

use App\Library\Media\DataObjects\Movie;
use App\Library\Media\Responses\BaseResponse;
use Illuminate\Support\Collection;

class MoviesResponse extends BaseResponse
{
    public function getData(): Collection
    {
        return collect(
            array_map(
                fn (object $movie) => new Movie($movie),
                json_decode($this->getResponse()->getBody()->getContents())
            )
        );
    }
}
