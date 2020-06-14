<?php

namespace App\Library\Media\DataObjects;

use App\Traits\PropertyExistsParent;

class Serie extends MediaItem
{
    use PropertyExistsParent;

    protected array $seasons;

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