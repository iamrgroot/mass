<?php

namespace App\Library\Media\DataObjects;

use App\Enums\TorrentStatus;
use App\Enums\TorrentStatusRpc;
use App\Traits\ConvertFromObject;

class Torrent
{
    use ConvertFromObject;

    public int $id;
    public int $status;
    public string $status_icon;
    public string $name;
    public ?string $error_string;
    public int $eta;
    public bool $isFinished;
    public int $rate_download;
    public int $rate_upload;
    public int $size_when_done;
    public float $percent_done;

    public function __construct(object $object)
    {
        $this->fromObject($object);

        if ('' === $this->error_string) {
            $this->error_string = null;
        }

        switch ($this->status) {
            case TorrentStatusRpc::Downloading:
                $this->status = TorrentStatus::Downloading;
                break;

            case TorrentStatusRpc::Seeding:
                $this->status = TorrentStatus::Seeding;
                break;

            case TorrentStatusRpc::Paused:
                $this->status = 1.0 === $this->percent_done ? TorrentStatus::Done : TorrentStatus::Paused;
                break;
        }

        $this->status_icon = $this->statusIcon();
    }

    private function statusIcon(): string
    {
        $icons = [
            TorrentStatus::Downloading => '$mdiDownload',
            TorrentStatus::Seeding     => '$mdiUpload',
            TorrentStatus::Paused      => '',
            TorrentStatus::Done        => '$mdiCheck',
        ];

        return $icons[$this->status];
    }
}
