<?php

namespace App\Library\Http;

use App\Library\Http\Exceptions\ConnectionException;
use App\Library\Http\Exceptions\NoResponseException;
use App\Library\Http\RequestInterface;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\BadResponseException;

class Client extends GuzzleClient
{
    public function doRequest(RequestInterface $request): ResponseInterface
    {
        try {
            $response = $this->request($request->getMethod(), $request->getUrl());
        } catch (BadResponseException $e) {
            throw new ConnectionException($e->getResponse()->getBody()->getContents(), $e->getCode(), $e);
        }
        catch (Exception $e) {
            throw ConnectionException::create($e);
        }

        if ($response->getBody()->getContents() === '') {
            throw new NoResponseException('No response from ' . $request->getUrl());
        }

        $response->getBody()->rewind();

        return $request->getResponseData($response);
    }
}
