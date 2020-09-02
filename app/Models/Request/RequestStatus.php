<?php

namespace App\Models\Request;

use App\Models\BaseModel;

class RequestStatus extends BaseModel
{
    public const REQUEST  = 1;
    public const DOWNLOAD = 2;
    public const DONE     = 3;
    public const DENIED   = 4;
}
