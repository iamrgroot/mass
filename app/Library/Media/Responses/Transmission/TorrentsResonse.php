<?php

namespace App\Library\Media\Responses\Transmission;

use App\Library\Media\DataObjects\Torrent;
use App\Library\Media\Responses\BaseResponse;
use Illuminate\Support\Collection;

class TorrentsResonse extends BaseResponse
{
    public function getData(): Collection
    {
        return collect(
            array_map(
                fn(object $torrent) => new Torrent($torrent), 
                json_decode($this->getResponse()->getBody()->getContents())->arguments->torrents
            )
        );
    }
}