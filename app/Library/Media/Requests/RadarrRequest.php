<?php

namespace App\Library\Media\Requests;

abstract class RadarrRequest extends BaseRequest
{
    public function getHost(): string
    {
        return (string) config('apis.radarr.host');
    }

    public function getPort(): int
    {
        return config('apis.radarr.port');
    }
 
    public function getApiString(): string
    {
        $api_key = config('apis.radarr.api_key');;
        
        return "?apikey={$api_key}";
    }
}