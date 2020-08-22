<?php

namespace App\Library\Media\Requests\Sonarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\SonarrRequest;
use App\Library\Media\Responses\Shared\StringResponse;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class AddManualRequest extends SonarrRequest
{
    private int $indexer_id;
    private string $guid;

    public function __construct(int $indexer_id, string $guid)
    {
        $this->indexer_id = $indexer_id;
        $this->guid       = $guid;
    }

    public function getRoute(): string
    {
        return 'api/release';
    }

    public function getMethod(): string
    {
        return Request::METHOD_POST;
    }

    public function getJson(): array
    {
        return [
            'guid'      => $this->guid,
            'indexerId' => $this->indexer_id,
        ];
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new StringResponse($response);
    }
}
