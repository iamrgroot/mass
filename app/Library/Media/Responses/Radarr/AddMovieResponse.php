<?php

namespace App\Library\Media\Responses\Radarr;

use App\Library\Media\DataObjects\Movie;
use App\Library\Media\Responses\BaseResponse;
use Illuminate\Support\Collection;

class AddMovieResponse extends BaseResponse
{
    public function getData(): Collection
    {
        dd($this->getResponse()->getBody()->getContents());
        return collect(
            array_map(
                fn(object $movie) => new Movie($movie), 
                json_decode($this->getResponse()->getBody()->getContents())
            )
        );
    }
}