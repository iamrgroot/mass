<?php

use Illuminate\Support\Facades\Route;

Route::domain('home.' . config('app.host'))->group(function () {
    Route::middleware('guest')->group(static function () {
        Route::get('/login', 'Auth\LoginController@page')->name('login');
        Route::post('/login', 'Auth\LoginController@login')->name('login');
    });

    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::middleware('auth')
        ->group(static function () {
            Route::get('/phpinfo', function () {
                phpinfo();
            })->name('phpinfo');

            $routes = [
                '',
                'movies',
                'series',
                'movies/\d+',
                'series/\d+',
                'torrents',
            ];

            $routes = array_map(fn ($route) => "({$route})", $routes);
            $routes = implode('|', $routes);

            Route::get('/{route}', function () {
                return view('home');
            })->where('route', $routes);
        });
});
