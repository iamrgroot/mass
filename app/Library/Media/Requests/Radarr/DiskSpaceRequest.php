<?php

namespace App\Library\Media\Requests\Radarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\RadarrRequest;
use App\Library\Media\Responses\Shared\DiskSpaceResponse;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class DiskSpaceRequest extends RadarrRequest
{
    public function getRoute(): string
    {
        return 'api/diskspace';
    }

    public function getMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new DiskSpaceResponse($response);
    }
}
