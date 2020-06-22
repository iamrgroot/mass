<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Library\Http\Client;
use App\Library\Media\Requests\Transmission\TorrentsRequest;
use App\Library\Media\Requests\Transmission\TorrentStartRequest;
use App\Library\Media\Requests\Transmission\TorrentStopRequest;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;

class TorrentController extends Controller
{
    public function torrents(Client $client): Collection
    {
        try {
            return $client->doRequest(new TorrentsRequest())->getData();
        } catch (RequestException $exception) {
            Artisan::call('config:cache');
        }

        return $client->doRequest(new TorrentsRequest())->getData();
    }

    public function start(int $torrent_id, Client $client): Collection
    {
        try {
            $client->doRequest(new TorrentStartRequest($torrent_id))->getData();
        } catch (RequestException $exception) {
            Artisan::call('config:cache');
        }

        $client->doRequest(new TorrentStartRequest($torrent_id))->getData();

        return $this->torrents($client);
    }

    public function stop(int $torrent_id, Client $client): Collection
    {
        try {
            $client->doRequest(new TorrentStopRequest($torrent_id))->getData();
        } catch (RequestException $exception) {
            Artisan::call('config:cache');
        }

        $client->doRequest(new TorrentStopRequest($torrent_id))->getData();

        return $this->torrents($client);
    }
}