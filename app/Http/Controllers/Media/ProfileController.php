<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Library\Http\Client;
use App\Library\Media\Requests\Sonarr\ProfileRequest;
use Illuminate\Support\Collection;

class ProfileController extends Controller
{
    public function fromMovies(Client $client): Collection
    {
        return $client->doRequest(new ProfileRequest())->getData();
    }
}
