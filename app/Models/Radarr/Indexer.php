<?php

namespace App\Models\Radarr;

use App\Models\Shared\Indexer as SharedIndexer;

class Indexer extends SharedIndexer
{
    protected $connection = 'radarr_sqlite';

    public static function getDefaults(): array
    {
        $host = config('apis.jackett.host');
        $port = config('apis.jackett.port');
        $api_key = config('apis.jackett.aoi_key');

        return [
            'Id' => '1',
            'Name' => 'Jackett',
            'Implementation' => 'Torznab',
            'Settings' => "{
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
            'EnableRss' => '1',
            'EnableSearch' => '1',
        ];
    }
}
