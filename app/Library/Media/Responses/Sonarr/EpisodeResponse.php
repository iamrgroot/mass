<?php

namespace App\Library\Media\Responses\Sonarr;

use App\Library\Media\DataObjects\Episode;
use App\Library\Media\Responses\BaseResponse;
use Illuminate\Support\Collection;

class EpisodeResponse extends BaseResponse
{
    public function getData(): Collection
    {
        return collect(
            array_map(
                fn (object $serie) => new Episode($serie),
                json_decode($this->getResponse()->getBody()->getContents())
            )
        );
    }
}
