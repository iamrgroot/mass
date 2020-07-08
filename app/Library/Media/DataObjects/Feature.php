<?php

namespace App\Library\Media\DataObjects;

class Feature
{
    public string $color;
    public string $text;

    public function __construct(string $text, string $color = 'grey')
    {
        $this->color = $color;
        $this->text  = $text;
    }
}
