<?php

namespace App\Library\Media\Requests\Radarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\RadarrRequest;
use App\Library\Media\Responses\Shared\StringResponse;
use GuzzleHttp\Psr7\Response;

class MovieImageRequest extends RadarrRequest 
{
    private int $movie_id;

    public function __construct(int $movie_id)
    {
        $this->movie_id = $movie_id;
    }

    public function getRoute(): string
    {
        return "api/MediaCover/{$this->movie_id}/poster.jpg";
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new StringResponse($response);
    }
}