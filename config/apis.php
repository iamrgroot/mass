<?php

$sonarr_config = new SimpleXMLElement(
    file_get_contents(
        base_path('docker-compose/sonarr/config/config.xml')
    )
);

$radarr_config = new SimpleXMLElement(
    file_get_contents(
        base_path('docker-compose/radarr/config/config.xml')
    )
);

$jackett_config = json_decode(
    file_get_contents(
        base_path('docker-compose/jackett/config/Jackett/ServerConfig.json')
    )
);

$transmission_config = json_decode(
    file_get_contents(
        base_path('docker-compose/transmission/config/settings.json')
    )
);

return [
    'sonarr' => [
        'host' => env('SONARR_HOST', 'sonarr'),
        'ip' => gethostbyname(env('SONARR_HOST', 'sonarr')),
        'port' => (int) $sonarr_config->Port,
        'api_key' => (string) $sonarr_config->ApiKey,
        'folder' => env('SONARR_HOST', '/tv/'),
    ],
    'radarr' => [
        'host' => env('RADARR_HOST', 'radarr'),
        'ip' => gethostbyname(env('SONARR_HOST', 'radarr')),
        'port' => (int) $radarr_config->Port,
        'api_key' => (string) $radarr_config->ApiKey,
        'folder' => env('RADARR_FOLDER', '/movies/'),
    ],
    'transmission' => [
        'host' => env('TRANSMISSION_HOST', 'transmission'),
        'ip' => gethostbyname(env('TRANSMISSION_HOST', 'transmission')),
        'port' => (int) $transmission_config->{'rpc-port'},
    ],
    'jackett' => [
        'host' => env('RADARR_HOST', 'jackett'),
        'ip' => gethostbyname(env('SONARR_HOST', 'jackett')),
        'port' => (int) $jackett_config->Port,
        'api_key' => (string) $jackett_config->APIKey,
    ],
];
