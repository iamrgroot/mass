<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    /**
     * Disable timestamps on model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Allow mass assignment.
     *
     * @var array
     */
    public $guarded = [];

    public static function getMaintenanceFields(): array
    {
        return [];
    }
}
