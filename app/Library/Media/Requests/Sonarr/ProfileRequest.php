<?php

namespace App\Library\Media\Requests\Sonarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\SonarrRequest;
use App\Library\Media\Responses\Shared\ProfileResponse;
use GuzzleHttp\Psr7\Response;

class ProfileRequest extends SonarrRequest 
{
    public function getRoute(): string
    {
        return 'api/profile';
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new ProfileResponse($response);
    }
}