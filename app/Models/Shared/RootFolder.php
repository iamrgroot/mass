<?php

namespace App\Models\Shared;

use App\Models\BaseModel;

class RootFolder extends BaseModel
{
    protected $table = 'RootFolders';

    public static function getDescription(): string
    {
        return 'Root folder';
    }
}
