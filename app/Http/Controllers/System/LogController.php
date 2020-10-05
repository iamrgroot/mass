<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\CpuLog;
use App\Models\System\DiskLog;
use App\Models\System\MemoryLog;
use Illuminate\Support\Collection;

class LogController extends Controller
{
    public function cpuLogs(): Collection
    {
        return CpuLog::latest()->limit(100)->get();
    }

    public function diskLogs(): Collection
    {
        return DiskLog::latest()->limit(100)->get();
    }

    public function MemoryLogs(): Collection
    {
        return MemoryLog::latest()->limit(100)->get();
    }
}
