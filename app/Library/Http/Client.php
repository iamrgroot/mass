<?php

namespace App\Library\Http;

use GuzzleHttp\Client as GuzzleClient;

class Client extends GuzzleClient
{
    public function doRequest(RequestInterface $request): ResponseInterface
    {
        $response = $this->request(
            $request->getMethod(),
            $request->getUrl(),
            [
                'json'    => $request->getJson(),
                'headers' => $request->getHeaders(),
            ]
        );

        return $request->getResponseData($response);
    }
}
