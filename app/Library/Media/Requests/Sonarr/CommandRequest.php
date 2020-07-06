<?php

namespace App\Library\Media\Requests\Sonarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\SonarrRequest;
use App\Library\Media\Responses\Shared\StringResponse;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class CommandRequest extends SonarrRequest
{
    private array $json;

    public function __construct(array $json)
    {
        $this->json = $json;
    }

    public function getRoute(): string
    {
        return 'api/command';
    }

    public function getMethod(): string
    {
        return Request::METHOD_POST;
    }

    public function getJson(): array
    {
        return $this->json;
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new StringResponse($response);
    }
}
