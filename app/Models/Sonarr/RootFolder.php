<?php

namespace App\Models\Sonarr;

use App\Models\Shared\RootFolder as SharedRootFolder;

class RootFolder extends SharedRootFolder
{
    protected $connection = 'sonarr_sqlite';

    protected static function getPath(): string
    {
        return config('apis.sonarr.folder');
    }
}
