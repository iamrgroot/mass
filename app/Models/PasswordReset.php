<?php

namespace App\Models;

class PasswordReset extends BaseModel
{
    protected string $primaryKey = 'email';
    protected bool $incrementing = false;
    protected string $keyType    = 'string';
}
