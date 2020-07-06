<?php

namespace App\Library\Media\DataObjects;

use App\Traits\ConvertFromObject;

class Profile
{
    use ConvertFromObject;

    public int $id;
    public string $name;

    public function __construct(object $object)
    {
        $this->fromObject($object);
    }
}
