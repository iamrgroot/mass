<?php

namespace Tests\Feature;

use App\Library\Http\Client;
use App\Library\Http\RequestInterface;
use App\Library\Http\ResponseInterface;
use App\Library\Media\DataObjects\Movie;
use App\Library\Media\Requests\Radarr\AddMovieRequest;
use App\Library\Media\Requests\Radarr\DeleteMovieRequest;
use App\Library\Media\Requests\Radarr\MovieRequest;
use App\Library\Media\Requests\Radarr\MoviesRequest;
use App\Library\Media\Requests\Radarr\ProfileRequest as RadarrProfileRequest;
use App\Library\Media\Requests\Radarr\SearchRequest as RadarrSearchRequest;
use App\Library\Media\Requests\Sonarr\ProfileRequest as SonarrProfileRequest;
use Illuminate\Http\Response;
use Tests\TestCase;

class ApisTest extends TestCase
{
    public function testSonarr(): void
    {
        $this->handleRequest(new SonarrProfileRequest());

        // /** @var Movie $movie */
        // $movie = $this->handleRequest(new AddMovieRequest($this->movieJson()))->getData();

        // $this->handleRequest(new RadarrSearchRequest('batman'));
        // $this->handleRequest(new MoviesRequest());
        // $this->handleRequest(new MovieRequest($movie->id));
        // $this->handleRequest(new DeleteMovieRequest($movie->id));
    }

    public function testRadarr(): void
    {
        $this->handleRequest(new RadarrProfileRequest());

        /** @var Movie $movie */
        $movie = $this->handleRequest(new AddMovieRequest($this->movieJson()))->getData();

        $this->handleRequest(new RadarrSearchRequest('batman'));
        $this->handleRequest(new MoviesRequest());
        $this->handleRequest(new MovieRequest($movie->id));
        $this->handleRequest(new DeleteMovieRequest($movie->id));
    }

    private function handleRequest(RequestInterface $request): ResponseInterface
    {
        $client = new Client();
        $response = $client->doRequest($request);

        $this->assertContains($response->getResponse()->getStatusCode(), [
            Response::HTTP_OK,
            Response::HTTP_CREATED,
        ]);

        return $response;
    }

    private function movieJson(): array
    {
        return [
            "title" => "Bat*21",
            "qualityProfileId" => 1,
            "titleSlug" => "bat21-14911",
            "images" => [
              [
                "coverType" => "poster",
                "url" => "http://image.tmdb.org/t/p/original/yIeFT2RqJdXMRIhGLs05xtzBkt9.jpg",
              ],
              [
                "coverType" => "fanart",
                "url" => "http://image.tmdb.org/t/p/original/lh5lbisD4oDbEKgUxoRaZU8HVrk.jpg",
              ],
            ],
            "tmdbId" => 14911,
            "year" => 1988,
            "path" => "/movies/APITEST",
            "monitored" => false,
            "addOptions" => [
              "searchForMovie" => false,
            ],
            "title" => "Bat*21",
        ];
    }
}
