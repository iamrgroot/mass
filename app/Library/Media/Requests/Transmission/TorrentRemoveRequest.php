<?php

namespace App\Library\Media\Requests\Transmission;

class TorrentRemoveRequest extends TorrentRequest 
{
    public function getJson(): array
    {
        return [
            'method' => 'torrent-remove',
            'arguments' => [
                'ids' => [ $this->torrent_id ],
                'delete-local-data' => true
            ]
        ];
    }
}