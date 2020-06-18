<?php

namespace App\Models\Radarr;

use App\Models\Shared\Indexer as SharedIndexer;

class Indexer extends SharedIndexer
{
    protected $connection = 'radarr_sqlite';
}
