<?php

namespace App\Traits;

trait ConvertFromObject
{
    use SnakeCaser;

    protected function fromObject(object $object): void
    {
        foreach ($object as $key => $value) {
            $key = self::snakeCase($key);

            $skip = self::propertyExists('skipped') && in_array($key, $this->skipped);

            if (! $skip && self::propertyExists($key)) {
                $this->{$key} = $value;
            }
        }
    }

    protected static function propertyExists(string $key): string
    {
        return property_exists(self::class, $key) ||
            (
                (bool) class_parents(self::class) &&
                method_exists(parent::class, 'propertyExists') &&
                parent::propertyExists($key)
            );
    }
}
