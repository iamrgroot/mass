<?php

namespace App\Models\Request;

use App\Models\BaseModel;

class RequestStatus extends BaseModel
{
    public const REQUEST  = 0;
    public const DOWNLOAD = 1;
    public const DONE     = 2;
    public const DENIED   = 3;
}
