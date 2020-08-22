<?php

namespace App\Library\Media\Requests\Sonarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\SonarrRequest;
use App\Library\Media\Responses\Shared\ManualSearchResponse;
use GuzzleHttp\Psr7\Response;

class ManualSearchRequest extends SonarrRequest
{
    private int $episode_id;

    public function __construct(int $episode_id)
    {
        $this->episode_id = $episode_id;
    }

    public function getRoute(): string
    {
        return 'api/release';
    }

    public function getParameters(): string
    {
        return "&episodeId={$this->episode_id}";
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new ManualSearchResponse($response);
    }
}
