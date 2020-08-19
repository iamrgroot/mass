<?php

namespace App\Enums;

abstract class TorrentStatusRpc
{
    public const Paused = 0;
    public const Downloading = 4;
    public const Seeding = 6;
}
