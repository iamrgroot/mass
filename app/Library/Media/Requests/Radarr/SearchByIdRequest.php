<?php

namespace App\Library\Media\Requests\Radarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\RadarrRequest;
use App\Library\Media\Responses\Shared\SearchResponse;
use GuzzleHttp\Psr7\Response;

class SearchByIdRequest extends RadarrRequest
{
    private int $tmdb_id;

    public function __construct(int $tmdb_id)
    {
        $this->tmdb_id = $tmdb_id;
    }

    public function getRoute(): string
    {
        return 'api/movie/lookup/tmdb';
    }

    public function getParameters(): string
    {
        return "&tmdbId={$this->tmdb_id}";
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new SearchResponse($response);
    }
}
