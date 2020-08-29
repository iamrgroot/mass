<?php

use Illuminate\Support\Facades\Route;

Route::domain(config('app.host'))->group(function () {
    Route::middleware('guest')->group(static function () {
        Route::get('/login', 'Auth\LoginController@page')->name('login');
        Route::post('/login', 'Auth\LoginController@login')->name('login');
    });

    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::middleware('auth')->group(static function () {
        $routes = [
            '',
            'movies',
            'series',
            'movies\/\d+',
            'series\/\d+',
            'torrents',
            'requests',
        ];

        Route::get('/{route}', 'Auth\RouteController@view')
            ->where('route', implode('|', array_map(fn ($route) => "({$route})", $routes)));

        $maintenance_routes = [
            'users',
            'roles',
        ];
        Route::get('/maintenance/{route}', 'Maintenance\MaintenanceController@view')
            ->where('route', implode('|', array_map(fn ($route) => "({$route})", $maintenance_routes)));
    });
});
