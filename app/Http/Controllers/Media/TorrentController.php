<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Library\Http\Client;
use App\Library\Http\RequestInterface;
use App\Library\Http\ResponseInterface;
use App\Library\Media\Requests\Transmission\TorrentRemoveRequest;
use App\Library\Media\Requests\Transmission\TorrentsRequest;
use App\Library\Media\Requests\Transmission\TorrentStartRequest;
use App\Library\Media\Requests\Transmission\TorrentStopRequest;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;

class TorrentController extends Controller
{
    public function torrents(): Collection
    {
        return $this->doRequest(new TorrentsRequest())->getData();
    }

    public function delete(int $torrent_id): Collection
    {
        $this->doRequest(new TorrentRemoveRequest($torrent_id));

        return $this->torrents();
    }

    public function start(int $torrent_id): Collection
    {
        $this->doRequest(new TorrentStartRequest($torrent_id));

        return $this->torrents();
    }

    public function stop(int $torrent_id): Collection
    {
        $this->doRequest(new TorrentStopRequest($torrent_id));

        return $this->torrents();
    }

    private function doRequest(RequestInterface $request): ResponseInterface
    {
        $client = new Client();

        try {
            return $client->doRequest($request);
        } catch (RequestException $exception) {
            Artisan::call('config:cache');
        }

        return $client->doRequest($request);
    }
}
