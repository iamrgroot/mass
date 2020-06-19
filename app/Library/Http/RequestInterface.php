<?php 

namespace App\Library\Http;

use GuzzleHttp\Psr7\Response;

interface RequestInterface
{
    public function getPort(): int;
    public function getHost(): string;
    public function getMethod(): string;
    public function getApiString(): string;
    public function getRoute(): string;
    public function getUrl(): string;
    public function getParameters(): string;
    public function getResponseData(Response $response): ResponseInterface;
}