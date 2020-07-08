<?php

namespace App\Library\Media\Responses\Radarr;

use App\Library\Media\DataObjects\Movie;
use App\Library\Media\Responses\BaseResponse;

class MovieResponse extends BaseResponse
{
    public function getData(): Movie
    {
        return new Movie(
            json_decode(
                $this->getResponse()->getBody()->getContents()
            )
        );
    }
}
