<?php

namespace App\Console\Commands;

use App\Library\Http\Client;
use App\Library\Media\DataObjects\Disk;
use App\Library\Media\Requests\Radarr\DiskSpaceRequest;
use App\Library\Media\Responses\Shared\DiskSpaceResponse;
use App\Models\System\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DiskLogCommand extends Command
{
    protected $signature   = 'log:disk';
    protected $description = 'Logs disk info to database.';

    public function handle()
    {
        Log::debug('Running DiskLogCommand...');

        $setting = Setting::whereDiskLog()->firstOrFail();

        if (true !== $setting->value) {
            Log::debug('Memory log disabled in settings');

            return 0;
        }

        $request = new DiskSpaceRequest();

        /** @var DiskSpaceResponse $response */
        $disks = (new Client())->doRequest($request)->getData();

        /** @var Disk $disk */
        foreach ($disks as $disk) {
            $disk->toDiskLog()->save();
        }
    }
}
