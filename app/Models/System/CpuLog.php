<?php

namespace App\Models\System;

use App\Models\BaseModel;

/**
 * App\Models\System\CpuLog.
 *
 * @property int                        $id
 * @property float                      $cpu_usage
 * @property \Illuminate\Support\Carbon $created_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CpuLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CpuLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CpuLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|CpuLog whereCpuUsage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CpuLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CpuLog whereId($value)
 * @mixin \Eloquent
 */
class CpuLog extends BaseModel
{
    // Disable created_at timestamp column
    const UPDATED_AT = null;

    public $timestamps = true;
}
