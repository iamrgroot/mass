<?php

namespace App\Console\Commands\IdeHelper;

use Barryvdh\LaravelIdeHelper\Console\ModelsCommand as BaseModelsCommand;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use ReflectionObject;

class ModelsCommand extends BaseModelsCommand
{
    /**
     * Fixes error on models with compoship relations.
     *
     * @param string   $relation
     * @param Relation $relationObj
     *
     * @return bool
     */
    protected function isRelationNullable(string $relation, Relation $relationObj): bool
    {
        $reflectionObj = new ReflectionObject($relationObj);

        if (in_array($relation, ['hasOne', 'hasOneThrough', 'morphOne'], true) || ! $reflectionObj->hasProperty('foreignKey')) {
            return parent::isRelationNullable($relation, $relationObj);
        }

        $fkProp = $reflectionObj->getProperty('foreignKey');
        $fkProp->setAccessible(true);

        return (bool) Arr::first(
            (array) $fkProp->getValue($relationObj),
            fn (string $value) => isset($this->nullableColumns[$value])
        );
    }
}
