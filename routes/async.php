<?php

use Illuminate\Support\Facades\Route;

Route::domain('home.' . env('SITE_URL', 'localhost'))->group(function () {

    Route::middleware('auth')->group(static function () {
        Route::prefix('movies')->group(static function() {
            Route::get('', 'Media\MovieController@movies');
            Route::put('', 'Media\MovieController@put');
            Route::get('{id}', 'Media\MovieController@movie');
            Route::delete('{id}/delete', 'Media\MovieController@delete');
            Route::get('{id}/image', 'Media\MovieController@image');
            Route::get('{search}/search', 'Media\MovieController@search');
        });

        Route::prefix('series')->group(static function() {
            Route::put('', 'Media\SerieController@put');
            Route::get('', 'Media\SerieController@series');
            Route::get('{id}', 'Media\SerieController@serie');
            Route::delete('{id}/delete', 'Media\SerieController@delete');
            Route::get('{id}/image', 'Media\SerieController@image');
            Route::put('{id}/toggle-season', 'Media\SerieController@toggleSeason');
            Route::get('{search}/search', 'Media\SerieController@search');
        });

        Route::prefix('profiles')->group(static function() {
            Route::get('from-movies', 'Media\ProfileController@fromMovies');
            Route::get('from-series', 'Media\ProfileController@fromSeries');
        });

        Route::prefix('torrents')->group(static function() {
            Route::get('', 'Media\TorrentController@torrents');

            Route::post('{id}/stop', 'Media\TorrentController@stop');
            Route::post('{id}/start', 'Media\TorrentController@start');
        });
    });

});
