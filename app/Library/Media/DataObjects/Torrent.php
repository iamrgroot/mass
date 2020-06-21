<?php

namespace App\Library\Media\DataObjects;

use App\Traits\ConvertFromObject;

class Torrent
{
    use ConvertFromObject;

    public int $id;
    public int $status;
    public string $name;
    public ?string $error_string;
    public int $eta;
    public bool $isFinished;
    public int $rate_download;
    public int $rate_upload;
    public int $size_when_done;
    public float $percent_done;
    
    public function __construct(object $object)
    {
        $this->fromObject($object);

        if ($this->error_string === '') {
            $this->error_string = null;
        }
    }
}