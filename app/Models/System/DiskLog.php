<?php

namespace App\Models\System;

use App\Models\BaseModel;

/**
 * App\Models\System\DiskLog.
 *
 * @property int                        $id
 * @property string                     $path
 * @property int                        $used_space
 * @property int                        $total_space
 * @property \Illuminate\Support\Carbon $created_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DiskLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiskLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiskLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|DiskLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiskLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiskLog wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiskLog whereTotalSpace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiskLog whereUsedSpace($value)
 * @mixin \Eloquent
 */
class DiskLog extends BaseModel
{
    // Disable created_at timestamp column
    const UPDATED_AT = null;

    public $timestamps = true;
}
