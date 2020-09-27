<?php

namespace App\Console\Commands;

use App\Models\System\CpuLog;
use App\Models\System\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Linfo\Linfo;

class CpuLogCommand extends Command
{
    protected $signature   = 'log:cpu';
    protected $description = 'Logs cpu info to database.';

    public function handle()
    {
        $setting = Setting::whereDiskLog()->firstOrFail();

        if (true !== $setting->value) {
            Log::debug('Memory log disabled in settings');

            return 0;
        }

        /** @var Linux $parser */
        $parser = (new Linfo())->getParser();
        $parser->determineCPUPercentage();

        CpuLog::create([
            'cpu_usage' => $parser->getCPUUsage(),
        ]);
    }
}
