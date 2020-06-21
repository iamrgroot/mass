<?php

namespace App\Library\Media\Requests\Sonarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\SonarrRequest;
use App\Library\Media\Responses\Shared\SearchResponse;
use GuzzleHttp\Psr7\Response;

class SearchRequest extends SonarrRequest 
{
    private string $search_term;

    public function __construct(string $search_term)
    {
        $this->search_term = $search_term;
    }

    public function getRoute(): string
    {
        return 'api/series/lookup';
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