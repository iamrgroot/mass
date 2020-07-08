<?php

namespace App\Library\Media\Requests\Transmission;

class TorrentStopRequest extends TorrentRequest
{
    public function getJson(): array
    {
        return [
            'method'    => 'torrent-stop',
            'arguments' => [
                'ids' => [$this->torrent_id],
            ],
        ];
    }
}
