<?php

namespace App\Library\Media\Handlers;

use App\Library\Http\Client;
use App\Library\Media\Requests\TransmissionRequest;
use GuzzleHttp\Exception\ClientException;

class TransmissionSessionGetter
{
    public static function getSession(string $transmission_ip, string $transmission_port): string
    {
        $request = new TransmissionRequest();

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

        return $transmission_session_id;
    }
}
