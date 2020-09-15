<?php

use Illuminate\Support\Facades\Route;

Route::domain(config('app.host'))->group(static function () {
    Route::middleware('auth')->group(static function () {
        /*
         * Admin routes
         */
        Route::middleware('role:admin')->group(static function () {
            Route::prefix('maintenance')
                ->group(static function () {
                    Route::get('{table}', 'Maintenance\MaintenanceController@items');
                    Route::patch('{table}', 'Maintenance\MaintenanceController@update');
                    Route::delete('{table}/{id}', 'Maintenance\MaintenanceController@delete');
                });

            Route::prefix('movies')->group(static function () {
                Route::get('', 'Media\MovieController@movies');
                Route::get('{id}', 'Media\MovieController@movie');
                Route::get('{id}/image', 'Media\MovieController@image');
                Route::get('{id}/manual-search', 'Media\MovieController@manualSearch');

                Route::post('search-missing', 'Media\MovieController@searchMissing');
                Route::post('{id}/search-indexer', 'Media\MovieController@searchIndexer');
                Route::post('{id}/refresh', 'Media\MovieController@refresh');
                Route::post('{indexer_id}/add-manual', 'Media\MovieController@addManual');

                Route::put('', 'Media\MovieController@put');

                Route::delete('{id}/delete', 'Media\MovieController@delete');
            });

            Route::prefix('series')->group(static function () {
                Route::get('', 'Media\SerieController@series');
                Route::get('{id}', 'Media\SerieController@serie');
                Route::get('{id}/image', 'Media\SerieController@image');
                Route::get('{id}/manual-search', 'Media\SerieController@manualSearch');

                Route::post('search-missing', 'Media\SerieController@searchMissing');
                Route::post('{id}/search-indexer', 'Media\SerieController@searchIndexer');
                Route::post('{id}/refresh', 'Media\SerieController@refresh');
                Route::post('{indexer_id}/add-manual', 'Media\SerieController@addManual');

                Route::put('', 'Media\SerieController@put');
                Route::put('{id}/toggle-season', 'Media\SerieController@toggleSeason');

                Route::delete('{id}/delete', 'Media\SerieController@delete');
            });

            Route::prefix('profiles')->group(static function () {
                Route::get('from-movies', 'Media\ProfileController@fromMovies');
                Route::get('from-series', 'Media\ProfileController@fromSeries');
            });

            Route::prefix('torrents')->group(static function () {
                Route::get('', 'Media\TorrentController@torrents');

                Route::delete('{id}/delete', 'Media\TorrentController@delete');

                Route::post('{id}/stop', 'Media\TorrentController@stop');
                Route::post('{id}/start', 'Media\TorrentController@start');
            });

            Route::prefix('requests')->group(static function () {
                Route::post('{request}/status/{status}', 'Requests\AdminRequestController@updateStatus');
            });

            Route::prefix('system')->group(static function () {
                Route::get('', 'System\SystemController@get');
            });
        });

        /* User routes */
        Route::middleware('role:user|admin')->group(static function () {
            Route::prefix('requests')->group(static function () {
                Route::get('', 'Requests\UserRequestController@requests');
                Route::put('', 'Requests\UserRequestController@put');
                Route::delete('{request}', 'Requests\UserRequestController@delete');
            });

            Route::get('movies/{search}/search', 'Media\MovieController@search');
            Route::get('series/{search}/search', 'Media\SerieController@search');
        });
    });
});
