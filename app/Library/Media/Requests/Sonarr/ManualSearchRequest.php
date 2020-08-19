<?php

namespace App\Library\Media\Requests\Sonarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\SonarrRequest;
use App\Library\Media\Responses\Shared\ManualSearchResponse;
use GuzzleHttp\Psr7\Response;

class ManualSearchRequest extends SonarrRequest
{
    private int $movie_id;

    public function __construct(int $movie_id)
    {
        $this->movie_id = $movie_id;
    }

    public function getRoute(): string
    {
        return 'api/release';
    }

    public function getParameters(): string
    {
        return "&movieId={$this->movie_id}";
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new ManualSearchResponse($response);
    }
}
