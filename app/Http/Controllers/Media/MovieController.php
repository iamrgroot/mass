<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Library\Http\Client;
use App\Library\Media\Requests\Radarr\AddMovieRequest;
use App\Library\Media\Requests\Radarr\MoviesRequest;
use App\Library\Media\Requests\Radarr\SearchRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MovieController extends Controller
{
    public function movies(Client $client): Collection
    {
        return $client->doRequest(new MoviesRequest())->getData();
    }

    public function search(string $search, Client $client): Collection
    {
        return $client->doRequest(new SearchRequest($search))->getData();        
    }

    public function put(Request $request, Client $client): Collection
    {
        $validated = $request->validate([
            'item.tmdb_id' => 'required|integer',
            'item.title' => 'required|string',
            'item.title_slug' => 'required|string',
            'item.year' => 'required|integer',
            'item.title_slug' => 'required|string',
            'item.images' => 'required|array',
            'profile' => 'required|integer',
        ]);

        $request = new AddMovieRequest([
            'title' => $validated['item']['title'],
            'qualityProfileId' => $validated['profile'],
            'titleSlug' => $validated['item']['title_slug'],
            'images' => $validated['item']['images'],
            'tmdbId' => $validated['item']['tmdb_id'],
            'year' => $validated['item']['year'],
            'path' => config('apis.radarr.folder') . $validated['item']['title'] . ' (' . $validated['item']['year'] . ')',
            'monitored' => true,
            'addOptions' => [
                'searchForMovie' => true
            ]
        ]);

        $response = $client->doRequest($request)->getData();

        return $this->movies($client);
    }
}
