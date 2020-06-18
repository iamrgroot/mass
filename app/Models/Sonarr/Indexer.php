<?php

namespace App\Models\Sonarr;

use App\Models\Shared\Indexer as SharedIndexer;

class Indexer extends SharedIndexer
{
    protected $connection = 'sonarr_sqlite';
}
