<?php

namespace App\Library\Media\Responses\Shared;

use App\Library\Media\DataObjects\SearchResult;
use App\Library\Media\Responses\BaseResponse;
use Illuminate\Support\Collection;

class SearchResponse extends BaseResponse
{
    public function getData(): Collection
    {
        return collect(
            array_map(
                fn (object $search_result) => new SearchResult($search_result),
                json_decode($this->getResponse()->getBody()->getContents())
            )
        );
    }
}
