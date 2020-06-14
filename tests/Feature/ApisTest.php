<?php

namespace Tests\Feature;

use App\Library\Http\Client;
use App\Library\Http\RequestInterface;
use App\Library\Media\Requests\Radarr\ProfileRequest as RadarrProfileRequest;
use App\Library\Media\Requests\Sonarr\ProfileRequest as SonarrProfileRequest;
use Illuminate\Http\Response;
use Tests\TestCase;

class ApisTest extends TestCase
{
    public function testSonarr(): void
    {
        $requests = [
            new SonarrProfileRequest(),
        ];

        foreach ($requests as $request) {
            $this->handleRequest($request);
        }
    }

    public function testRadarr(): void
    {
        $requests = [
            new RadarrProfileRequest(),
        ];

        foreach ($requests as $request) {
            $this->handleRequest($request);
        }
    }

    private function handleRequest(RequestInterface $request): void
    {
        $client = new Client();
        $response = $client->doRequest($request);

        $this->assertEquals($response->getResponse()->getStatusCode(), Response::HTTP_OK);
    }
}
