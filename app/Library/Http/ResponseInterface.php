<?php

namespace App\Library\Http;

use GuzzleHttp\Psr7\Response;

interface ResponseInterface
{
    public function __construct(Response $response);

    public function getResponse(): Response;

    public function getData();
}
