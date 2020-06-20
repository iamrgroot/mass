<?php

namespace App\Library\Media\Requests;

use App\Library\Http\RequestInterface;
use Illuminate\Http\Request;

abstract class BaseRequest implements RequestInterface
{
    public function getUrl(): string
    {
        return "http://{$this->getHost()}:{$this->getPort()}/{$this->getRoute()}{$this->getApiString()}{$this->getParameters()}";
    }

    public function getMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function getParameters(): string
    {
        return '';
    }

    public function getJson(): array
    {
        return [];
    }
}