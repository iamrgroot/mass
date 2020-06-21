<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Library\Http\Client;
use App\Library\Media\Requests\Transmission\TorrentsRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;

class TorrentController extends Controller
{
    public function torrents(Client $client): Collection
    {
        try {
            return $client->doRequest(new TorrentsRequest())->getData();
        } catch (\Throwable $th) {
            Artisan::call('config:cache');
        }

        return $client->doRequest(new TorrentsRequest())->getData();
    }
}