<?php

namespace App\Library\Media\DataObjects;

use App\Traits\SnakeCaser;
use Illuminate\Support\Collection;

class MediaItem
{
    use SnakeCaser;

    public int $type;
    public int $id;
    public int $profile_id;
    public string $title;
    public string $overview;
    public int $size_on_disk;
    public string $imdb_id;
    public int $year;
    public Collection $features;
    public string $image_url;
    public string $banner_url;

    public function __construct()
    {
        $this->features = collect();
    }
}
