<?php

namespace App\Models\Sonarr;

use App\Models\Shared\DownloadClient as SharedDownloadClient;

class DownloadClient extends SharedDownloadClient
{
    protected $connection = 'sonarr_sqlite';
}
