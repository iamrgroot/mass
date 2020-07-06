<?php

namespace App\Library\Media\DataObjects;

use App\Traits\ConvertFromObject;

class SearchResult
{
    use ConvertFromObject;

    public int $tvdb_id;
    public int $tmdb_id;
    public string $title;
    public string $title_slug;
    public int $year;
    public string $text;
    public array $images;
    public array $seasons;

    public function __construct(object $object)
    {
        $this->fromObject($object);

        $this->text = "{$this->title} ({$this->year})";
    }
}
