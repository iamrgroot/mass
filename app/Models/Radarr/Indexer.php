<?php

namespace App\Models\Radarr;

use App\Models\Shared\Indexer as SharedIndexer;

/**
 * App\Models\Radarr\Indexer.
 *
 * @property int         $Id
 * @property string      $Name
 * @property string      $Implementation
 * @property string|null $Settings
 * @property string|null $ConfigContract
 * @property int|null    $EnableRss
 * @property int|null    $EnableSearch
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereConfigContract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereEnableRss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereEnableSearch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereImplementation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indexer whereSettings($value)
 * @mixin \Eloquent
 */
class Indexer extends SharedIndexer
{
    protected $connection = 'radarr_sqlite';

    public static function getDefaults(): array
    {
        $host    = config('apis.jackett.host');
        $port    = config('apis.jackett.port');
        $api_key = config('apis.jackett.api_key');

        return [
            'Id'             => '1',
            'Name'           => 'Jackett',
            'Implementation' => 'Torznab',
            'Settings'       => "{
    'minimumSeeders': 1,
    'requiredFlags': [],
    'baseUrl': 'http://{$host}:{$port}/torznab/all',
    'multiLanguages': [],
    'apiKey': '{$api_key}',
    'categories': [
        2000,
        2010,
        2020,
        2030,
        2035,
        2040,
        2045,
        2050,
        2060
    ],
    'animeCategories': [],
    'removeYear': false,
    'searchByTitle': false
}",
            'ConfigContract' => 'TorznabSettings',
            'EnableRss'      => '1',
            'EnableSearch'   => '1',
        ];
    }
}
