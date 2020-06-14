<?php

return [
    'sonarr' => [
        'host' => env('SONARR_HOST', 'sonarr'),
        'port' => env('SONARR_PORT', '8989'),
        'api_key' => env('SONARR_API_KEY', 'X'),
    ],
    'radarr' => [
        'host' => env('RADARR_HOST', 'radarr'),
        'port' => env('RADARR_PORT', '7878'),
        'api_key' => env('RADARR_API_KEY', 'X'),
    ],
];
