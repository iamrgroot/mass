<?php

namespace App\Models\Shared;

use App\Models\BaseModel;

class Indexer extends BaseModel
{
    protected $table = 'Indexers';

    public static function getDescription(): string
    {
        return 'Jackett indexer';
    }
}
