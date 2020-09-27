<?php

namespace App\Console\Commands;

use App\Models\System\MemoryLog;
use App\Models\System\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Linfo\Linfo;

class MemoryLogCommand extends Command
{
    protected $signature = 'log:memory';

    protected $description = 'Logs memory info to database.';

    public function handle()
    {
        $setting = Setting::whereDiskLog()->firstOrFail();

        if (true !== $setting->value) {
            Log::debug('Memory log disabled in settings');

            return 0;
        }

        /** @var Linux $parser */
        $parser = (new Linfo())->getParser();
        $memory = $parser->getRam();

        MemoryLog::create([
            'used_space'  => $memory['total'] - $memory['free'],
            'total_space' => $memory['total'],
        ]);
    }
}
