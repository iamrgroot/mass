<?php

namespace App\Models\Sonarr;

use App\Models\Shared\Indexer as SharedIndexer;

class Indexer extends SharedIndexer
{
    protected $connection = 'sonarr_sqlite';

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
    'seedCriteria': {},
    'baseUrl': 'http://{$host}:{$port}/torznab/all',
    'apiPath': '/api',
    'apiKey': '{$api_key}',
    'categories': [
        5030,
        5040
    ],
    'animeCategories': []
}",
            'ConfigContract' => 'TorznabSettings',
            'EnableRss'      => '1',
            'EnableSearch'   => '1',
        ];
    }
}
