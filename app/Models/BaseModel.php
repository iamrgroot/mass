<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * Disable timestamps on model.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function getMaintenanceFields(): array
    {
        return [];
    }
}
