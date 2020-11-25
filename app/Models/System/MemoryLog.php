<?php

namespace App\Models\System;

use App\Models\BaseModel;

/**
 * App\Models\System\MemoryLog.
 *
 * @property int                        $id
 * @property int                        $used_space
 * @property int                        $total_space
 * @property \Illuminate\Support\Carbon $created_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MemoryLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemoryLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemoryLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|MemoryLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemoryLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemoryLog whereTotalSpace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemoryLog whereUsedSpace($value)
 * @mixin \Eloquent
 */
class MemoryLog extends BaseModel
{
    // Disable created_at timestamp column
    const UPDATED_AT = null;

    public $timestamps = true;
}
