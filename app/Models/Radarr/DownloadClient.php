<?php

namespace App\Models\Radarr;

use App\Models\Shared\DownloadClient as SharedDownloadClient;

class DownloadClient extends SharedDownloadClient
{
    protected $connection = 'radarr_sqlite';

    protected static function getIp(): string
    {
        return config('apis.radarr.ip');
    }

    protected static function getPort(): string
    {
        return config('apis.radarr.port');
    }
}
