<?php

namespace App\Library\Media\DataObjects;

use App\Traits\AddRatingFeature;
use App\Traits\ConvertFromObject;

class Serie extends MediaItem
{
    use ConvertFromObject;
    use AddRatingFeature;

    public array $seasons;

    public function __construct(object $object)
    {
        parent::__construct();
        $this->fromObject($object);

        $this->addRating($object);

        $this->seasons = array_map(
            fn (object $season) => new Season($season),
            $this->seasons
        );

        $this->features->add(new Feature(
            "{$object->episodeFileCount} / {$object->episodeCount}",
            $object->episodeFileCount === $object->episodeCount ?
                'success' :
                'grey'
        ));
    }
}
