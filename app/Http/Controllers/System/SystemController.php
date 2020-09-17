<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Linfo\Linfo;
use Linfo\OS\Linux;

class SystemController extends Controller
{
    public function get()
    {
        // https://github.com/jrgp/linfo

        /** @var Linux $parser */
        // $parser = (new Linfo())->getParser();
        // $parser->determineCPUPercentage();
        // dump($parser->getCPUUsage());
        // dump($parser->getVirtualization());
        // dump($parser->getUpTime());
        // dump($parser->getRam());
        // dump($parser->getCPU());
    }
}
