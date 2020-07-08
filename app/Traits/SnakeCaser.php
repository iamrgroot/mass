<?php

namespace App\Traits;

trait SnakeCaser
{
    protected static function snakeCase(string $string): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }
}
