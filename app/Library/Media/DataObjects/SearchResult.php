<?php

namespace App\Library\Media\DataObjects;

use App\Traits\ConvertFromObject;

class SearchResult
{
    use ConvertFromObject;

    public int $tmdb_id;
    public string $title;
    public int $year;
    public string $text;
    
    public function __construct(object $object)
    {
        $this->fromObject($object);

        $this->text = "{$this->title} ({$this->year})";
    }
}