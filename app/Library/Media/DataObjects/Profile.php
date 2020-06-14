<?php

namespace App\Library\Media\DataObjects;

class Profile
{
    private int $id;
    private string $name;
    
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function fromObject(object $object): self
    {
        return new self($object->id, $object->name);
    }
}