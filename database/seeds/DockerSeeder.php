<?php

use App\Models\Radarr\DownloadClient as RadarrDownloadClient;
use App\Models\Radarr\Indexer as RadarrIndexer;
use App\Models\Radarr\RootFolder as RadarrRootFolder;
use App\Models\Sonarr\DownloadClient as SonarrDownloadClient;
use App\Models\Sonarr\Indexer as SonarrIndexer;
use App\Models\Sonarr\RootFolder as SonarrRootFolder;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DockerSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedJackett();

        $this->seed(SonarrDownloadClient::class);
        $this->seed(SonarrIndexer::class);
        $this->seed(SonarrRootFolder::class);

        $this->seed(RadarrDownloadClient::class);
        $this->seed(RadarrIndexer::class);
        $this->seed(RadarrRootFolder::class);
    }

    private function seedJackett(): void
    {
        /** @var FilesystemAdapter $init_disk */
        $init_disk = Storage::disk('init-jacket-files');

        /** @var FilesystemAdapter $jacket_disk */
        $jacket_disk = Storage::disk('jackett');

        foreach ($init_disk->files() as $file) {
            $destination = $jacket_disk->path('Indexers' . DIRECTORY_SEPARATOR . $file);

            if (! File::exists($destination)) {
                File::copy($init_disk->path($file), $destination);
            }
        }
    }

    private function seed(string $model): void
    {
        $message = $model::getDescription();

        if ($model::exists()) {
            $this->command->info("{$message} already exists!");
            return; 
        }

        $model::create($model::getDefaults());

        $this->command->info("Created {$message}!");
    }
}
