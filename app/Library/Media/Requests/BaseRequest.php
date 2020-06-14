<?php

namespace App\Library\Media\Requests;

use App\Library\Http\RequestInterface;

abstract class BaseRequest implements RequestInterface
{
    public function getUrl(): string
    {
        return "http://{$this->getHost()}:{$this->getPort()}/{$this->getRoute()}{$this->getApiString()}";
    }
}