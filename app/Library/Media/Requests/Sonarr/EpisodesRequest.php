<?php

namespace App\Library\Media\Requests\Sonarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\SonarrRequest;
use App\Library\Media\Responses\Sonarr\EpisodeResponse;
use GuzzleHttp\Psr7\Response;

class EpisodesRequest extends SonarrRequest
{
    private int $serie_id;

    public function __construct(int $serie_id)
    {
        $this->serie_id = $serie_id;
    }

    public function getRoute(): string
    {
        return 'api/episode';
    }

    public function getParameters(): string
    {
        return "&seriesId={$this->serie_id}";
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new EpisodeResponse($response);
    }
}
