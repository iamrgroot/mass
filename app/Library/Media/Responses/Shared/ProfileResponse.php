<?php

namespace App\Library\Media\Responses\Shared;

use App\Library\Media\DataObjects\Profile;
use App\Library\Media\Responses\BaseResponse;
use Illuminate\Support\Collection;

class ProfileResponse extends BaseResponse
{
    public function getData(): Collection
    {
        return collect(
            array_map(
                fn(object $profile) => Profile::fromObject($profile), 
                json_decode($this->getResponse()->getBody()->getContents())
            )
        );
    }
}