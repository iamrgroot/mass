<?php

namespace App\Library\Media\DataObjects;

use App\Traits\ConvertFromObject;

class ManualSearchResult
{
    use ConvertFromObject;

    public string $guid;
    public int $indexer_id;
    public string $quality;
    public float $age;
    public float $size;
    public string $title;
    public int $seeders;
    public int $leechers;
    public array $rejections;

    private array $skip = ['quality'];

    public function __construct(object $object)
    {
        $this->fromObject($object);

        if ($quality = $object->quality->quality->name ?? null) {
            $this->quality = $quality;
        }
    }
}
