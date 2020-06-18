<?php

namespace App\Models\Sonarr;

use App\Models\Shared\DownloadClient as SharedDownloadClient;

class DownloadClient extends SharedDownloadClient
{
    protected $connection = 'sonarr_sqlite';
    
    protected static function getIp(): string
    {
        return config('apis.sonarr.ip');
    }

    protected static function getPort(): string
    {
        return config('apis.sonarr.port');
    }
}
