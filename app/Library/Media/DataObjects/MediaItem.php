<?php

namespace App\Library\Media\DataObjects;

use App\Traits\SnakeCaser;

class MediaItem
{
    use SnakeCaser;

    protected int $id;
    protected string $title;
    protected int $size_on_disk;
    protected string $imdb_id;
    protected int $year;
    // protected Rating $ratings;
    
}