<?php

namespace App\Models\Radarr;

use App\Models\Shared\RootFolder as SharedRootFolder;

class RootFolder extends SharedRootFolder
{
    protected $connection = 'radarr_sqlite';
}
