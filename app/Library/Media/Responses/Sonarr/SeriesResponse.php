<?php

namespace App\Library\Media\Responses\Sonarr;

use App\Library\Media\DataObjects\Serie;
use App\Library\Media\Responses\BaseResponse;
use Illuminate\Support\Collection;

class SeriesResponse extends BaseResponse
{
    public function getData(): Collection
    {
        return collect(
            array_map(
                fn(object $serie) => new Serie($serie), 
                json_decode($this->getResponse()->getBody()->getContents())
            )
        );
    }
}