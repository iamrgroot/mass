<?php

namespace App\Library\Media\Requests\Sonarr;

use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\SonarrRequest;
use App\Library\Media\Responses\Shared\StringResponse;
use GuzzleHttp\Psr7\Response;

class SerieBannerImageRequest extends SonarrRequest
{
    private int $serie_id;

    public function __construct(int $serie_id)
    {
        $this->serie_id = $serie_id;
    }

    public function getRoute(): string
    {
        return "api/MediaCover/{$this->serie_id}/fanart.jpg";
    }

    public function getResponseData(Response $response): ResponseInterface
    {
        return new StringResponse($response);
    }
}
