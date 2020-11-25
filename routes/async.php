<?php

use App\Http\Controllers\Maintenance\MaintenanceController;
use App\Http\Controllers\Media\MovieController;
use App\Http\Controllers\Media\ProfileController;
use App\Http\Controllers\Media\SerieController;
use App\Http\Controllers\Media\TorrentController;
use App\Http\Controllers\Requests\AdminRequestController;
use App\Http\Controllers\Requests\UserRequestController;
use App\Http\Controllers\System\LogController;
use App\Http\Controllers\System\SystemController;
use Illuminate\Support\Facades\Route;

Route::domain(config('app.host'))->group(static function () {
    Route::middleware('auth')->group(static function () {
        /*
         * Admin routes
         */
        Route::middleware('role:admin')->group(static function () {
            Route::prefix('maintenance')
                ->group(static function () {
                    Route::get('{table}', [MaintenanceController::class, 'items']);
                    Route::patch('{table}', [MaintenanceController::class, 'update']);
                    Route::delete('{table}/{id}', [MaintenanceController::class, 'delete']);
                });

            Route::prefix('movies')->group(static function () {
                Route::get('', [MovieController::class, 'movies']);
                Route::get('{id}', [MovieController::class, 'movie']);
                Route::get('{id}/image', [MovieController::class, 'image']);
                Route::get('{id}/manual-search', [MovieController::class, 'manualSearch']);

                Route::post('search-missing', [MovieController::class, 'searchMissing']);
                Route::post('{id}/search-indexer', [MovieController::class, 'searchIndexer']);
                Route::post('{id}/refresh', [MovieController::class, 'refresh']);
                Route::post('{indexer_id}/add-manual', [MovieController::class, 'addManual']);

                Route::put('', [MovieController::class, 'put']);

                Route::delete('{id}/delete', [MovieController::class, 'delete']);

                Route::patch('{id}/profile', [MovieController::class, 'patchProfile']);
            });

            Route::prefix('series')->group(static function () {
                Route::get('', [SerieController::class, 'series']);
                Route::get('{id}', [SerieController::class, 'serie']);
                Route::get('{id}/image', [SerieController::class, 'image']);
                Route::get('{id}/manual-search', [SerieController::class, 'manualSearch']);

                Route::post('search-missing', [SerieController::class, 'searchMissing']);
                Route::post('{id}/search-indexer', [SerieController::class, 'searchIndexer']);
                Route::post('{id}/refresh', [SerieController::class, 'refresh']);
                Route::post('{indexer_id}/add-manual', [SerieController::class, 'addManual']);

                Route::put('', [SerieController::class, 'put']);
                Route::put('{id}/toggle-season', [SerieController::class, 'toggleSeason']);

                Route::delete('{id}/delete', [SerieController::class, 'delete']);

                Route::patch('{id}/profile', [SerieController::class, 'patchProfile']);
            });

            Route::prefix('profiles')->group(static function () {
                Route::get('from-movies', [ProfileController::class, 'fromMovies']);
                Route::get('from-series', [ProfileController::class, 'fromSeries']);
            });

            Route::prefix('torrents')->group(static function () {
                Route::get('', [TorrentController::class, 'torrents']);

                Route::delete('{id}/delete', [TorrentController::class, 'delete']);

                Route::post('{id}/stop', [TorrentController::class, 'stop']);
                Route::post('{id}/start', [TorrentController::class, 'start']);
            });

            Route::prefix('requests')->group(static function () {
                Route::post('{request}/status/{status}', [AdminRequestController::class, 'updateStatus']);
            });

            Route::prefix('system')->group(static function () {
                Route::get('settings', [SystemController::class, 'settings']);
                Route::patch('setting', [SystemController::class, 'patch']);
                Route::post('flush-cache', [SystemController::class, 'flushCache']);

                Route::get('cpu-logs', [LogController::class, 'cpuLogs']);
                Route::get('memory-logs', [LogController::class, 'memoryLogs']);
                Route::get('disk-logs', [LogController::class, 'diskLogs']);
                Route::get('laravel-logs', [LogController::class, 'laravelLogs']);
                Route::get('{index}/laravel-log', [LogController::class, 'laravelLog']);
            });
        });

        /* User routes */
        Route::middleware('role:user|admin')->group(static function () {
            Route::prefix('requests')->group(static function () {
                Route::get('', [UserRequestController::class, 'requests']);
                Route::put('', [UserRequestController::class, 'put']);
                Route::delete('{request}', [UserRequestController::class, 'delete']);
            });

            Route::get('movies/{search}/search', [MovieController::class, 'search']);
            Route::get('series/{search}/search', [SerieController::class, 'search']);
        });
    });
});
