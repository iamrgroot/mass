<?php

namespace App\Library\Media\Requests\Radarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\RadarrRequest;
use App\Library\Media\Responses\Radarr\MoviesResponse;
use App\Library\Media\Responses\Shared\SearchResponse;
use GuzzleHttp\Psr7\Response;

class SearchRequest extends RadarrRequest 
{
    private string $search_term;

    public function __construct(string $search_term)
    {
        $this->search_term = $search_term;
    }

    public function getRoute(): string
    {
        return 'api/movie/lookup';
    }

    public function getParameters(): string
    {
        return "&term={$this->search_term}";
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new SearchResponse($response);
    }
}