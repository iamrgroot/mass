<?php

use Illuminate\Support\Facades\Route;

Route::domain('home.' . env('SITE_URL', 'localhost'))->group(function () {
    Route::get('login', 'Auth\LoginController@page')
        ->name('login');

    Route::post('login', 'Auth\LoginController@login')
        ->name('login');

    Route::get('logout', 'Auth\LoginController@logout')
        ->name('logout');

    Route::name('web.')
        ->middleware('auth')
        ->group(static function () {
            Route::get('/phpinfo', function () {
                phpinfo();
            })->name('phpinfo');

            Route::get('/', function () {
                return view('home');
            });
        });
});

Route::domain(env('SITE_URL', 'localhost'))->group(function () {
    Route::get('/', function () {
        return view('me');
    });
});
