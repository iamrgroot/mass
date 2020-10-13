<?php

namespace App\Library\Media\DataObjects;

use App\Library\Http\Client;
use App\Library\Media\Requests\Sonarr\EpisodesRequest;
use App\Traits\AddRatingFeature;
use App\Traits\ConvertFromObject;

class Serie extends MediaItem
{
    use ConvertFromObject;
    use AddRatingFeature;

    public array $seasons;

    public function __construct(object $object)
    {
        parent::__construct();
        $this->fromObject($object);

        $this->addRating($object);

        $profiles = config('profiles.from_serie');
        $key      = array_search($this->profile_id, array_column($profiles, 'id'));

        $this->features->add(new Feature($profiles[$key]['name'] ?? '???'));

        $client   = new Client();
        $request  = new EpisodesRequest($this->id);
        $episodes = $client->doRequest($request)->getData()->groupBy('season_number');

        $this->seasons = array_map(fn (object $season) => new Season($season, $episodes[$season->seasonNumber] ?? collect()),
            $this->seasons
        );

        $this->features->add(new Feature(
            "{$object->episodeFileCount} / {$object->episodeCount}",
            $object->episodeFileCount === $object->episodeCount ?
                'success' :
                'grey'
        ));
    }
}
