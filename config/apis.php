<?php

use App\Library\Media\Handlers\TransmissionSessionGetter;
use Illuminate\Support\Facades\Log;

$default = [
    'sonarr' => [
        'host'    => env('SONARR_HOST', null),
        'ip'      => env('SONARR_IP', null),
        'port'    => env('SONARR_PORT', null),
        'api_key' => env('SONARR_API_KEY', null),
        'folder'  => env('SONARR_FOLDER', null),
    ],
    'radarr' => [
        'host'    => env('RADARR_HOST', null),
        'ip'      => env('RADARR_IP', null),
        'port'    => env('RADARR_PORT', null),
        'api_key' => env('RADARR_API_KEY', null),
        'folder'  => env('RADARR_FOLDER', null),
    ],
    'transmission' => [
        'host'       => env('TRANSMISSION_HOST', null),
        'ip'         => env('TRANSMISSION_IP', null),
        'port'       => env('TRANSMISSION_PORT', null),
        'session_id' => null,
    ],
    'jackett' => [
        'host'    => env('JACKETT_HOST', null),
        'ip'      => env('JACKETT_IP', null),
        'port'    => env('JACKETT_PORT', null),
        'api_key' => env('JACKETT_API_KEY', null),
    ],
];

if (false === env('AUTO_CONFIG', true)) {
    try {
        $default['transmission.session_id'] = TransmissionSessionGetter::getSession($default['transmission.ip'], $default['transmission.port']);
    } catch (\Throwable $th) {
        try {
            Log::error($th->getMessage());
        } catch (\Throwable $th) {
            // Do nothing
        }
    }

    return $default;
}

try {
    $files = [
        base_path('docker-compose/sonarr/config/config.xml'),
        base_path('docker-compose/radarr/config/config.xml'),
        base_path('docker-compose/jackett/config/Jackett/ServerConfig.json'),
        base_path('docker-compose/transmission/config/settings.json'),
    ];

    foreach ($files as $file) {
        if (! file_exists($file)) {
            return $default;
        }
    }

    $sonarr_config = new SimpleXMLElement(
        file_get_contents($files[0])
    );

    $radarr_config = new SimpleXMLElement(
        file_get_contents($files[1])
    );

    $jackett_config = json_decode(
        file_get_contents($files[2])
    );

    $transmission_config = json_decode(
        file_get_contents($files[3])
    );

    $transmission_host       = env('TRANSMISSION_HOST', 'transmission');
    $transmission_ip         = gethostbyname($transmission_host);
    $transmission_port       = (int) $transmission_config->{'rpc-port'};
    $transmission_session_id = TransmissionSessionGetter::getSession($transmission_ip, $transmission_port);

    return [
        'sonarr' => [
            'host'    => env('SONARR_HOST', 'sonarr'),
            'ip'      => gethostbyname(env('SONARR_HOST', 'sonarr')),
            'port'    => (int) $sonarr_config->Port,
            'api_key' => (string) $sonarr_config->ApiKey,
            'folder'  => env('SONARR_HOST', '/tv/'),
        ],
        'radarr' => [
            'host'    => env('RADARR_HOST', 'radarr'),
            'ip'      => gethostbyname(env('SONARR_HOST', 'radarr')),
            'port'    => (int) $radarr_config->Port,
            'api_key' => (string) $radarr_config->ApiKey,
            'folder'  => env('RADARR_FOLDER', '/movies/'),
        ],
        'transmission' => [
            'host'       => $transmission_host,
            'ip'         => $transmission_ip,
            'port'       => $transmission_port,
            'session_id' => $transmission_session_id,
        ],
        'jackett' => [
            'host'    => env('RADARR_HOST', 'jackett'),
            'ip'      => gethostbyname(env('SONARR_HOST', 'jackett')),
            'port'    => (int) $jackett_config->Port,
            'api_key' => (string) $jackett_config->APIKey,
        ],
    ];
} catch (Throwable $exception) {
    return $default;
}
