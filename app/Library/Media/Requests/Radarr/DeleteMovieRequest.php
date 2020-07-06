<?php

namespace App\Library\Media\Requests\Radarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\RadarrRequest;
use App\Library\Media\Responses\Shared\StringResponse;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class DeleteMovieRequest extends RadarrRequest
{
    private int $movie_id;

    public function __construct(int $movie_id)
    {
        $this->movie_id = $movie_id;
    }

    public function getRoute(): string
    {
        return "api/movie/{$this->movie_id}";
    }

    public function getMethod(): string
    {
        return Request::METHOD_DELETE;
    }

    public function getJson(): array
    {
        return [
            'deleteFiles'  => true,
            'addExclusion' => false,
        ];
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new StringResponse($response);
    }
}
