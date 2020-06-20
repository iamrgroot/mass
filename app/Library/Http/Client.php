<?php

namespace App\Library\Http;

use App\Library\Http\Exceptions\ConnectionException;
use App\Library\Http\Exceptions\NoResponseException;
use App\Library\Http\RequestInterface;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Facades\Http;

class Client extends GuzzleClient
{
    public function doRequest(RequestInterface $request): ResponseInterface
    {
        $response = $this->request(
            $request->getMethod(),
            $request->getUrl(),
            [
                'json' => $request->getJson()
            ]
        );

        if ($response->getBody()->getContents() === '') {
            throw new NoResponseException('No response from ' . $request->getUrl());
        }

        $response->getBody()->rewind();

        return $request->getResponseData($response);
    }
}
