<?php

namespace App\Library\Media\DataObjects;

use App\Models\System\DiskLog;
use App\Traits\ConvertFromObject;

class Disk
{
    use ConvertFromObject;

    public string $path;
    public int $free_space;
    public int $total_space;

    public function __construct(object $object)
    {
        $this->fromObject($object);
    }

    public function toDiskLog(): DiskLog
    {
        return new DiskLog([
            'path'        => $this->path,
            'used_space'  => $this->total_space - $this->free_space,
            'total_space' => $this->total_space,
        ]);
    }
}
