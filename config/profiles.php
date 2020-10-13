<?php

use App\Library\Http\Client;
use App\Library\Media\DataObjects\Profile;
use App\Library\Media\Requests\Radarr\ProfileRequest as RadarrProfileRequest;
use App\Library\Media\Requests\Sonarr\ProfileRequest as SonarrProfileRequest;
use Illuminate\Support\Facades\Log;

$from_movie = [];
$from_serie = [];

try {
    $client     = new Client();
    $from_movie = $client->doRequest(new RadarrProfileRequest())->getData()->toArray();
    $from_serie = $client->doRequest(new SonarrProfileRequest())->getData()->toArray();

    $from_movie = array_map(fn (Profile $profile) => (array) $profile, $from_movie);
    $from_serie = array_map(fn (Profile $profile) => (array) $profile, $from_serie);
} catch (\Throwable $th) {
    Log::error($th->getMessage());
}

return [
    'from_movie' => $from_movie,
    'from_serie' => $from_serie,
];
