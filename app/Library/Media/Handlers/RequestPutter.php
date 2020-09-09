<?php

namespace App\Library\Media\Handlers;

use App\Enums\ItemType;
use App\Library\Http\Client;
use App\Library\Media\DataObjects\SearchResult;
use App\Library\Media\Requests\Radarr\AddMovieRequest;
use App\Library\Media\Requests\Radarr\SearchByIdRequest as MovieSearchByIdRequest;
use App\Library\Media\Requests\Sonarr\AddSerieRequest;
use App\Library\Media\Requests\Sonarr\SearchByIdRequest as SerieSearchByIdRequest;
use App\Models\Request\Request;

class RequestPutter
{
    // TODO make configurable
    private const PROFILE_ID = 1;

    public static function put(Request $request): void
    {
        if ($request->type === ItemType::Movie) {
            self::putMovie($request);
        } else {
            self::putSerie($request);
        }
    }

    private static function putMovie(Request $request): void
    {
        $client = new Client();
        $search_request = new MovieSearchByIdRequest($request->item_id);

        /** @var SearchResult $result */
        $result = $client->doRequest($search_request)->getData()->first();

        $put_request = new AddMovieRequest([
            'title'            => $result->title,
            'qualityProfileId' => self::PROFILE_ID,
            'titleSlug'        => $result->title_slug,
            'images'           => $result->images,
            'tmdbId'           => $result->tmdb_id,
            'year'             => $result->year,
            'path'             => config('apis.radarr.folder') . $result->title . ' (' . $result->year . ')',
            'monitored'        => true,
            'addOptions'       => [
                'searchForMovie' => true,
            ],
        ]);

        $client->doRequest($put_request)->getData();
    }

    private static function putSerie(Request $request): void
    {
        $client = new Client();
        $search_request = new SerieSearchByIdRequest($request->item_id);

        /** @var SearchResult $result */
        $result = $client->doRequest($search_request)->getData()->first();

        $put_request = new AddSerieRequest([
            'title'            => $result->title,
            'qualityProfileId' => self::PROFILE_ID,
            'titleSlug'        => $result->title_slug,
            'images'           => $result->images,
            'tvdbId'           => $result->tvdb_id,
            'year'             => $result->year,
            'seasons'          => $result->seasons,
            'path'             => config('apis.radarr.folder') . $result->title,
            'monitored'        => true,
            'seasonFolder'     => true,
            'addOptions'       => [
                'searchForMissingEpisodes' => true,
            ],
        ]);

        $client->doRequest($put_request)->getData();
    }
}