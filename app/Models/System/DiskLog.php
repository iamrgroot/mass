<?php

namespace App\Models\System;

use App\Models\BaseModel;

class DiskLog extends BaseModel
{
    // Disable created_at timestamp column
    const UPDATED_AT = null;

    public $timestamps = true;
}
