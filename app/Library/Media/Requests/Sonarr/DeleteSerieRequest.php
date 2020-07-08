<?php

namespace App\Library\Media\Requests\Sonarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\SonarrRequest;
use App\Library\Media\Responses\Shared\StringResponse;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class DeleteSerieRequest extends SonarrRequest
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

    public function getMethod(): string
    {
        return Request::METHOD_DELETE;
    }

    public function getJson(): array
    {
        return [
            'deleteFiles' => true,
        ];
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new StringResponse($response);
    }
}
