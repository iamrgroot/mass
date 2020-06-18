<?php

namespace App\Models\Shared;

use App\Models\BaseModel;

class DownloadClient extends BaseModel
{
    protected $table = 'DownloadClients';

    public static function getDescription(): string
    {
        return 'Transmission client';
    }

    public static function getDefaults(): array
    {
        return [
            'Id' => '1',
            'Enable' => '1',
            'Name' => 'Transmission',
            'Implementation' => 'Transmission',
            'Settings' => "{
                'host': '172.19.0.5',
                'port': 9091,
                'urlBase': '/transmission/',
                'username': '',
                'password': '',
                'recentTvPriority': 0,
                'olderTvPriority': 0,
                'addPaused': false,
                'useSsl': false
            }",
            'ConfigContract' => 'TransmissionSettings'
        ];
    }
}
