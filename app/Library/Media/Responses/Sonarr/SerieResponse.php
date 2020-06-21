<?php

namespace App\Library\Media\Responses\Sonarr;

use App\Library\Media\DataObjects\Serie;
use App\Library\Media\Responses\BaseResponse;

class SerieResponse extends BaseResponse
{
    public function getData(): Serie
    {
        return new Serie(
            json_decode(
                $this->getResponse()->getBody()->getContents()
            )
        );
    }
}