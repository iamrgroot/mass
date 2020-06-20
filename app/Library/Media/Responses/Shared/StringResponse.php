<?php

namespace App\Library\Media\Responses\Shared;

use App\Library\Media\Responses\BaseResponse;

class StringResponse extends BaseResponse
{
    public function getData(): string
    {
        return $this->getResponse()->getBody()->getContents();
    }
}