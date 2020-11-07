<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RouteController;
use App\Http\Controllers\Maintenance\MaintenanceController;
use App\Http\Controllers\Media\ImageController;
use Illuminate\Support\Facades\Route;

Route::domain(config('app.host'))->group(function () {
    Route::middleware('guest')->group(static function () {
        Route::get('/login', [LoginController::class, 'page'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
    });

    Route::get('/logout', [LoginController::class, 'logout']);

    Route::middleware('auth')->group(static function () {
        Route::get('image', [ImageController::class, 'image']);

        Route::middleware('role:user|admin')->group(static function () {
            Route::get('', [RouteController::class, 'view']);
        });

        Route::middleware('role:admin')->group(static function () {
            $routes = [
                'movies',
                'series',
                'movies\/\d+',
                'series\/\d+',
                'torrents',
                'requests',
                'system',
            ];

            Route::get('/{route}', [RouteController::class, 'view'])
                ->where('route', implode('|', array_map(fn ($route) => "({$route})", $routes)));

            $maintenance_routes = [
                'users',
            ];
            Route::get('/maintenance/{route}', [MaintenanceController::class, 'view'])
                ->where('route', implode('|', array_map(fn ($route) => "({$route})", $maintenance_routes)));
        });
    });
});
