<?php

namespace App\Library\Media\Responses\Shared;

use App\Library\Media\DataObjects\ManualSearchResult;
use App\Library\Media\Responses\BaseResponse;
use Illuminate\Support\Collection;

class ManualSearchResponse extends BaseResponse
{
    public function getData(): Collection
    {
        return collect(
            array_map(
                fn (object $search_result) => new ManualSearchResult($search_result),
                json_decode($this->getResponse()->getBody()->getContents())
            )
        );
    }
}
