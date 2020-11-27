<?php

namespace App\Library\Media\DataObjects;

use App\Enums\ItemType;
use App\Traits\AddRatingFeature;
use App\Traits\ConvertFromObject;
use App\Traits\FormatBytes;

class Movie extends MediaItem
{
    use ConvertFromObject;
    use AddRatingFeature;
    use FormatBytes;

    public string $sort_title;

    public function __construct(object $object)
    {
        parent::__construct();
        $this->fromObject($object);

        $timestamp        = now()->timestamp;
        $this->image_url  = "/async/movies/{$this->id}/image?{$timestamp}";
        $this->banner_url = "/async/movies/{$this->id}/banner?{$timestamp}";

        $this->type = ItemType::Movie;
        $this->addRating($object);

        $profiles = config('profiles.from_movie');
        $key      = array_search($this->profile_id, array_column($profiles, 'id'));

        $this->features->add(new Feature($profiles[$key]['name'] ?? '???'));

        if (! $object->hasFile) {
            return;
        }

        $this->features->add(new Feature($this->formatBytes($object->sizeOnDisk)));

        if ($object->movieFile->mediaInfo->videoBitDepth >= 10) {
            $this->features->add(new Feature('HDR', 'success'));
        }
        if ($quality = $object->movieFile->quality->quality->name ?? null) {
            $this->features->add(new Feature($quality));
        }
    }
}
