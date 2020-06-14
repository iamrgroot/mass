<?php

namespace App\Models\Sonarr;

use App\Models\BaseModel;

class DownloadClient extends BaseModel
{
    protected $connection = 'sonarr_sqlite';
    protected $table = 'DownloadClients';
}
