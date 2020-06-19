<?php

namespace App\Library\Media\DataObjects;

use App\Traits\SnakeCaser;

class MediaItem
{
    use SnakeCaser;

    public int $id;
    public string $title;
    public int $size_on_disk;
    public string $imdb_id;
    public int $year;
    // protected Rating $ratings;
    
}