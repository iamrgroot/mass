<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Library\Http\Client;
use App\Library\Media\Requests\Radarr\AddManualRequest;
use App\Library\Media\Requests\Radarr\AddMovieRequest;
use App\Library\Media\Requests\Radarr\DeleteMovieRequest;
use App\Library\Media\Requests\Radarr\ManualSearchRequest;
use App\Library\Media\Requests\Radarr\MovieImageRequest;
use App\Library\Media\Requests\Radarr\MovieRequest;
use App\Library\Media\Requests\Radarr\MoviesRequest;
use App\Library\Media\Requests\Radarr\RefreshRequest;
use App\Library\Media\Requests\Radarr\SearchCommandRequest;
use App\Library\Media\Requests\Radarr\SearchMissingRequest;
use App\Library\Media\Requests\Radarr\SearchRequest;
use App\Library\Media\Responses\Radarr\AddMovieResponse;
use App\Traits\ResizedImageResponse;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    use ResizedImageResponse;

    public function movies(Client $client): Collection
    {
        return $client->doRequest(new MoviesRequest())->getData();
    }

    public function movie(int $id, Client $client): JsonResponse
    {
        return response()->json(
            $client->doRequest(new MovieRequest($id))->getData()
        );
    }

    public function search(string $search, Client $client): Collection
    {
        return $client->doRequest(new SearchRequest($search))->getData();
    }

    public function put(Request $request, Client $client): JsonResponse
    {
        $validated = $request->validate([
            'item.tmdb_id'    => 'required|integer',
            'item.title'      => 'required|string',
            'item.title_slug' => 'required|string',
            'item.year'       => 'required|integer',
            'item.title_slug' => 'required|string',
            'item.images'     => 'required|array',
            'profile'         => 'required|integer',
        ]);

        $request = new AddMovieRequest([
            'title'            => $validated['item']['title'],
            'qualityProfileId' => $validated['profile'],
            'titleSlug'        => $validated['item']['title_slug'],
            'images'           => $validated['item']['images'],
            'tmdbId'           => $validated['item']['tmdb_id'],
            'year'             => $validated['item']['year'],
            'path'             => config('apis.radarr.folder') . $validated['item']['title'] . ' (' . $validated['item']['year'] . ')',
            'monitored'        => true,
            'addOptions'       => [
                'searchForMovie' => true,
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
        $client->doRequest(new DeleteMovieRequest($id));

        return response('ok');
    }

    public function image(int $id, Client $client): Response
    {
        $response = $client->doRequest(new MovieImageRequest($id))->getData();

        return $this->resizeResponse($response, 400);
    }

    public function refresh(int $id, Client $client): Response
    {
        $client->doRequest(new RefreshRequest($id));

        return response('ok');
    }

    public function searchIndexer(int $id, Client $client): Response
    {
        $client->doRequest(new SearchCommandRequest($id));

        return response('ok');
    }

    public function searchMissing(Client $client): Response
    {
        $client->doRequest(new SearchMissingRequest());

        return response('ok');
    }

    public function manualSearch(int $id, Client $client): Collection
    {
        return $client->doRequest(new ManualSearchRequest($id))->getData();
    }

    public function addManual(Request $request, int $indexer_id, Client $client): Response
    {
        $validated = $request->validate([
            'guid' => 'required|string',
        ]);

        $client->doRequest(new AddManualRequest($indexer_id, $validated['guid']));

        return response('ok');
    }
}
