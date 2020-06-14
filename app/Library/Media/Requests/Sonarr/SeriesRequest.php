<?php

namespace App\Library\Media\Requests\Sonarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\SonarrRequest;
use App\Library\Media\Responses\Sonarr\SeriesResponse;
use GuzzleHttp\Psr7\Response;

class SeriesRequest extends SonarrRequest 
{
    public function getRoute(): string
    {
        return 'api/series';
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new SeriesResponse($response);
    }
}