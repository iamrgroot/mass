<?php

namespace App\Library\Media\Requests\Sonarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\SonarrRequest;
use App\Library\Media\Responses\Sonarr\SerieResponse;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class UpdateSerieRequest extends SonarrRequest
{
    private array $updated_data;

    public function __construct(array $updated_data)
    {
        $this->updated_data = $updated_data;
    }

    public function getRoute(): string
    {
        return "api/series";
    }

    public function getMethod(): string
    {
        return Request::METHOD_PUT;
    }

    public function getJson(): array
    {
        return $this->updated_data;
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new SerieResponse($response);
    }
}