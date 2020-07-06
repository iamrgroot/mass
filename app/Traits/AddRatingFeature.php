<?php

namespace App\Traits;

use App\Library\Media\DataObjects\Feature;

trait AddRatingFeature
{
    protected function addRating(object $object): void
    {
        $rating = $object->ratings->value ?? null;

        if ($rating) {
            $this->features->add(new Feature(
                $object->ratings->value,
                $rating >= 7 ?
                    'success' :
                    ($rating >= 5 ? 'warning' : 'error')
            ));
        }
    }
}
