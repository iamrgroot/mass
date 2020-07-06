<?php

namespace App\Library\Media\Requests\Transmission;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\TransmissionRequest;
use App\Library\Media\Responses\Transmission\TorrentsResonse;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class TorrentsRequest extends TransmissionRequest
{
    public function getMethod(): string
    {
        return Request::METHOD_POST;
    }

    public function getJson(): array
    {
        return [
            'method'    => 'torrent-get',
            'arguments' => [
                'fields' => [
                    'id',
                    'status',
                    'name',
                    'errorString',
                    'eta',
                    'isFinished',
                    'rateDownload',
                    'rateUpload',
                    'sizeWhenDone',
                    'percentDone',
                ],
            ],
        ];
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new TorrentsResonse($response);
    }
}
