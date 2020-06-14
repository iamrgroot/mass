<?php

namespace App\Library\Media\Requests;

use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

abstract class RadarrRequest extends BaseRequest
{
    public function getHost(): string
    {
        return (string) config('apis.radarr.host');
    }

    public function getPort(): int
    {
        $config = new SimpleXMLElement(
            Storage::disk('radarr')->get('config/config.xml')
        );

        return (int) $config->Port;
    }
 
    public function getApiString(): string
    {
        $config = new SimpleXMLElement(
            Storage::disk('radarr')->get('config/config.xml')
        );

        $api_key = (string) $config->ApiKey;
        
        return "?apikey={$api_key}";
    }
}