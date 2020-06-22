<?php

namespace App\Library\Media\DataObjects;

use App\Enums\ItemType;
use App\Traits\AddRatingFeature;
use App\Traits\ConvertFromObject;

class Movie extends MediaItem
{
    use ConvertFromObject;
    use AddRatingFeature;

    public string $sort_title;

    public function __construct(object $object)
    {
        parent::__construct();
        $this->fromObject($object);

        $this->type = ItemType::Movie;
        $this->addRating($object);

        if (! $object->hasFile) {
            return;
        }

        $this->features->add(new Feature($object->sizeOnDisk));

        if ($object->movieFile->mediaInfo->videoBitDepth >= 10){
            $this->features->add(new Feature('HDR', 'success'));
        }
        if ($quality = $object->movieFile->quality->quality->name ?? null){
            $this->features->add(new Feature($quality));
        }
    }
}