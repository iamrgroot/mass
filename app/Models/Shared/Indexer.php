<?php

namespace App\Models\Shared;

use App\Models\BaseModel;

class Indexer extends BaseModel
{
    protected $table = 'Indexers';

    public static function getDescription(): string
    {
        return 'Jackett indexer';
    }

    public static function getDefaults(): array
    {
        $host = config('apis.jackett.host');
        $port = config('apis.jackett.port');
        $api_key = config('apis.jackett.port');

        return [
            'Id' => '1',
            'Name' => 'Jackett',
            'Implementation' => 'Torznab',
            'Settings' => "{
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
            'EnableRss' => '1',
            'EnableSearch' => '1',
        ];
    }
}
