<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Library\Http\Client;
use App\Library\Media\Requests\Radarr\MoviesRequest;
use App\Library\Media\Requests\Radarr\SearchRequest;
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
}
