<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CreateNginxConfig extends Command
{
    protected $signature = 'make:nginx-confg';

    protected $description = 'Creates nginx config from stub';

    public function handle()
    {
        /** @var FilesystemAdapter $stub_disk */
        $stub_disk = Storage::disk('nginx-stub');

        /** @var FilesystemAdapter $nginx_disk */
        $nginx_disk = Storage::disk('nginx');

        $name = 'mass.conf';

        $content = $stub_disk->get($name);
        $content = str_replace('${SERVER_NAME}', config('app.host'), $content);

        $destination = $nginx_disk->path($name);

        if (! File::exists($destination)) {
            File::put($destination, $content);
        }
    }
}
