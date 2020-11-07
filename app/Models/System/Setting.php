<?php

namespace App\Models\System;

use App\Models\BaseModel;
use Exception;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\System\Setting
 *
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property bool|int|mixed $value
 * @property string $component
 * @property \Illuminate\Support\Carbon $updated_at
 * @property integer $updated_by
 * @method static Builder|Setting newModelQuery()
 * @method static Builder|Setting newQuery()
 * @method static Builder|Setting query()
 * @method static Builder|Setting whereComponent($value)
 * @method static Builder|Setting whereCpuULog()
 * @method static Builder|Setting whereDiskLog()
 * @method static Builder|Setting whereId($value)
 * @method static Builder|Setting whereMemoryLog()
 * @method static Builder|Setting whereMovieProfile()
 * @method static Builder|Setting whereName($value)
 * @method static Builder|Setting whereSerieProfile()
 * @method static Builder|Setting whereType($value)
 * @method static Builder|Setting whereUpdatedAt($value)
 * @method static Builder|Setting whereUpdatedBy($value)
 * @method static Builder|Setting whereValue($value)
 * @mixin \Eloquent
 */
class Setting extends BaseModel
{
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_INTEGER = 'integer';

    public const NAME_LOG_CPU         = 'Log CPU';
    public const NAME_LOG_MEMORY      = 'Log memory';
    public const NAME_LOG_DISK        = 'Log disk';
    public const NAME_MOVIE_PROFILE   = 'Movie profile';
    public const NAME_SERIE_PROFILE   = 'Serie profile';

    // Disable created_at timestamp column
    const CREATED_AT = null;

    public $timestamps = true;

    public static function encodeValue($value, string $type): string
    {
        switch ($type) {
            case self::TYPE_BOOLEAN:
                return true === $value ? '1' : '0';
            case self::TYPE_INTEGER:
                return (string) $value;
        }

        throw new Exception("Type {$type} does not exist");
    }

    /**
     * @param mixed $value
     *
     * @return bool|int|mixed
     */
    public function getValueAttribute($value)
    {
        switch ($this->type) {
            case self::TYPE_BOOLEAN:
                return '1' === $value;
            case self::TYPE_INTEGER:
                return (int) $value;
        }

        throw new Exception("Type {$this->type} does not exist");
    }

    public function scopeWhereMovieProfile(Builder $query): Builder
    {
        return $query->where('name', self::NAME_MOVIE_PROFILE);
    }

    public function scopeWhereSerieProfile(Builder $query): Builder
    {
        return $query->where('name', self::NAME_SERIE_PROFILE);
    }

    public function scopeWhereCpuULog(Builder $query): Builder
    {
        return $query->where('name', self::NAME_LOG_CPU);
    }

    public function scopeWhereMemoryLog(Builder $query): Builder
    {
        return $query->where('name', self::NAME_LOG_MEMORY);
    }

    public function scopeWhereDiskLog(Builder $query): Builder
    {
        return $query->where('name', self::NAME_LOG_DISK);
    }
}
