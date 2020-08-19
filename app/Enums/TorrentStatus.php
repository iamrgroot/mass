<?php

namespace App\Enums;

abstract class TorrentStatus
{
    public const Paused      = 0;
    public const Downloading = 1;
    public const Seeding     = 2;
    public const Done        = 3;
}
