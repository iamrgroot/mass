<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\CpuLog;
use App\Models\System\DiskLog;
use App\Models\System\MemoryLog;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

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

    public function laravelLogs(): array
    {
        return $this->getLogFiles();
    }

    public function laravelLog(int $index): string
    {
        $logs = $this->getLogFiles();

        abort_if($index > count($logs), Response::HTTP_BAD_REQUEST);

        /** @var FilesystemAdapter $stub_disk */
        $disk = Storage::disk('logs');

        return $disk->get($logs[$index]);
    }

    private function getLogFiles(): array
    {
        /** @var FilesystemAdapter $stub_disk */
        $disk = Storage::disk('logs');

        return array_values(array_filter($disk->files(), fn (string $file) => str_ends_with($file, '.log')));
    }
}
