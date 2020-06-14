<?php 

namespace App\Traits;

trait PropertyExistsParent
{
    protected static function propertyExists(string $key): string
    {
        return true;
        return property_exists(self::class, $key) || 
            (
                (bool) class_parents(self::class) && 
                method_exists(parent::class, 'propertyExists') &&
                parent::propertyExists($key)
            );
    }
}