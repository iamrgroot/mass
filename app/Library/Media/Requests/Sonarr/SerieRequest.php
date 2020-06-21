<?php

namespace App\Library\Media\Requests\Sonarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\SonarrRequest;
use App\Library\Media\Responses\Sonarr\SerieResponse;
use GuzzleHttp\Psr7\Response;

class SerieRequest extends SonarrRequest 
{
    private int $serie_id;

    public function __construct(int $serie_id)
    {
        $this->serie_id = $serie_id;
    }

    public function getRoute(): string
    {
        return "api/series/{$this->serie_id}";
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new SerieResponse($response);
    }
}