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
        return [
            'Id' => '1',
            'Name' => 'Jackett',
            'Implementation' => 'Torznab',
            'Settings' => "{
                'minimumSeeders': 1,
                'seedCriteria': {},
                'baseUrl': 'http://jackett:9117/torznab/all',
                'apiPath': '/api',
                'apiKey': 'fq0gi66w0rb2ln6pwdled4kc2tgiist3',
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
