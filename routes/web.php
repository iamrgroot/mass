<?php

use Illuminate\Support\Facades\Route;

Route::domain('home.' . env('SITE_URL', 'localhost'))->group(function () {
    Route::get('/', function () {
        return view('login');
    });
});

Route::get('/', function () {
    return view('me');
});

Route::get('/phpinfo', function () {
    phpinfo();
});

Route::get('/test', 'TestController@test')
    ->name('test');

// Auth::routes();
