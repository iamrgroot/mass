<?php

namespace App\Models\Request;

use App\Models\BaseModel;

class RequestStatus extends BaseModel
{
    public const REQUEST  = 1;
    public const APPROVED = 2;
    public const DOWNLOADING = 3;
    public const DONE     = 4;
    public const DENIED   = 5;
    public const ERROR   = 6;
}
