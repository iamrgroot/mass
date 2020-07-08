<?php

namespace App\Models\Radarr;

use App\Models\Shared\DownloadClient as SharedDownloadClient;

class DownloadClient extends SharedDownloadClient
{
    protected $connection = 'radarr_sqlite';
}
