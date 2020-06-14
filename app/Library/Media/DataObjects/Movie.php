<?php

namespace App\Library\Media\DataObjects;

use App\Traits\PropertyExistsParent;

class Movie extends MediaItem
{
    use PropertyExistsParent;

    protected string $sort_title;

    public function __construct(object $object)
    {
        foreach($object as $key => $value) {
            $key = self::snakeCase($key);

            if (self::propertyExists($key)) {
                $this->{$key} = $value;
            }
        }
    }
}