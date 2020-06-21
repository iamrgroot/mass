<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Library\Http\Client;
use App\Library\Media\Requests\Sonarr\AddSerieRequest;
use App\Library\Media\Requests\Sonarr\DeleteSerieRequest;
use App\Library\Media\Requests\Sonarr\SearchRequest;
use App\Library\Media\Requests\Sonarr\SerieImageRequest;
use App\Library\Media\Requests\Sonarr\SerieRequest;
use App\Library\Media\Requests\Sonarr\SeriesRequest;
use App\Traits\ResizedImageResponse;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class SerieController extends Controller
{
    use ResizedImageResponse;

    public function series(Client $client): Collection
    {
        return $client->doRequest(new SeriesRequest())->getData();
    }

    public function serie(int $id, Client $client): JsonResponse
    {
        return response()->json(
            $client->doRequest(new SerieRequest($id))->getData()
        );
    }

    public function search(string $search, Client $client): Collection
    {
        return $client->doRequest(new SearchRequest($search))->getData();        
    }

    public function put(Request $request, Client $client): JsonResponse
    {
        $validated = $request->validate([
            'item.tvdb_id' => 'required|integer',
            'item.title' => 'required|string',
            'item.title_slug' => 'required|string',
            'item.year' => 'required|integer',
            'item.title_slug' => 'required|string',
            'item.images' => 'required|array',
            'item.seasons' => 'required|array',
            'profile' => 'required|integer',
            'seasons' => 'required|array',
        ]);

        $validated['item']['seasons'] = array_map(
            fn($season) => [ 
                'seasonNumber' => $season['seasonNumber'], 
                'monitored' => in_array($season['seasonNumber'], $validated['seasons'])
            ],
            $validated['item']['seasons']
        );

        $request = new AddSerieRequest([
            'title' => $validated['item']['title'],
            'qualityProfileId' => $validated['profile'],
            'titleSlug' => $validated['item']['title_slug'],
            'images' => $validated['item']['images'],
            'tvdbId' => $validated['item']['tvdb_id'],
            'year' => $validated['item']['year'],
            'seasons' => $validated['item']['seasons'],
            'path' => config('apis.sonarr.folder') . $validated['item']['title'],
            'monitored' => true,
            'seasonFolder' => true,
            'addOptions' => [
                'searchForMissingEpisodes' => true
            ],
        ]);

        try {
            /** @var AddMovieResponse $response */
            $response = $client->doRequest($request)->getData();
        } catch (BadResponseException $exception) {
            $errors = json_decode($exception->getResponse()->getBody()->getContents());
            
            return response()->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json($response);
    }

    public function delete(int $id, Client $client): Response
    {
        $client->doRequest(new DeleteSerieRequest($id));

        return response('ok');
    }

    public function image(int $id, Client $client): Response
    {
        $response = $client->doRequest(new SerieImageRequest($id))->getData();
        
        return $this->resizeResponse($response, 400);
    }
}
