<?php

namespace App\Library\Media\Requests\Sonarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\SonarrRequest;
use App\Library\Media\Responses\Shared\SearchResponse;
use GuzzleHttp\Psr7\Response;

class SearchByIdRequest extends SonarrRequest
{
    private int $tvdb_id;

    public function __construct(int $tvdb_id)
    {
        $this->tvdb_id = $tvdb_id;
    }

    public function getRoute(): string
    {
        return 'api/series/lookup';
    }

    public function getParameters(): string
    {
        return "&term=tvdb:{$this->tvdb_id}";
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new SearchResponse($response);
    }
}
