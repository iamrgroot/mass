<?php

namespace App\Library\Media;

use App\Library\Http\Client;
use App\Library\Media\Requests\TransmissionRequest;
use GuzzleHttp\Exception\ClientException;
use SimpleXMLElement;

class ConfigGetter
{
    public static function update(): void
    {
        config(['apis' => self::config()]);
    }

    public static function config(): array
    {
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

        $request = new TransmissionRequest();

        $transmission_host       = env('TRANSMISSION_HOST', 'transmission');
        $transmission_ip         = gethostbyname($transmission_host);
        $transmission_port       = (int) $transmission_config->{'rpc-port'};
        $transmission_session_id = '';

        try {
            $client = new Client();
            $client->request('GET', "http://{$transmission_ip}:{$transmission_port}/{$request->getRoute()}");
        } catch (ClientException $exception) {
            $response = $exception->getResponse()->getBody()->getContents();

            $matches = [];
            preg_match('/<code>(.+)<\/code>/', $response, $matches);

            if (count($matches) > 1) {
                $transmission_session_id = trim(explode(':', $matches[1])[1]);
            }
        }

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
    }
}
