<?php

namespace App\Library\Media\Requests\Transmission;

class TorrentStartRequest extends TorrentRequest
{
    public function getJson(): array
    {
        return [
            'method'    => 'torrent-start',
            'arguments' => [
                'ids' => [$this->torrent_id],
            ],
        ];
    }
}
