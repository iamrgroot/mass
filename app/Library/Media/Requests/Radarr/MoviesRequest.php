<?php

namespace App\Library\Media\Requests\Radarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\RadarrRequest;
use App\Library\Media\Responses\Radarr\MoviesResponse;
use GuzzleHttp\Psr7\Response;

class MoviesRequest extends RadarrRequest 
{
    public function getRoute(): string
    {
        return 'api/movie';
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new MoviesResponse($response);
    }
}