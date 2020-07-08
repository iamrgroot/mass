<?php

namespace App\Library\Media\Requests;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Responses\Shared\StringResponse;
use GuzzleHttp\Psr7\Response;

class TransmissionRequest extends BaseRequest
{
    public function getRoute(): string
    {
        return 'transmission/rpc';
    }

    public function getHost(): string
    {
        return (string) config('apis.transmission.ip');
    }

    public function getPort(): int
    {
        return config('apis.transmission.port');
    }

    public function getHeaders(): array
    {
        return [
            'X-Transmission-Session-Id' => config('apis.transmission.session_id'),
        ];
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new StringResponse($response);
    }
}
