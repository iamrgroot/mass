<?php

namespace App\Library\Media\Requests\Transmission;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\TransmissionRequest;
use App\Library\Media\Responses\Shared\StringResponse;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class TorrentRequest extends TransmissionRequest 
{
    protected int $torrent_id;

    public function __construct(int $torrent_id)
    {
        $this->torrent_id = $torrent_id;
    }

    public function getMethod(): string
    {
        return Request::METHOD_POST;
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new StringResponse($response);
    }
}