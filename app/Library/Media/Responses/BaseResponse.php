<?php

namespace App\Library\Media\Responses;

use App\Library\Http\ResponseInterface;
use GuzzleHttp\Psr7\Response;

abstract class BaseResponse implements ResponseInterface
{
    private Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
