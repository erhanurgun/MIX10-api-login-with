<?php

use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "Başlangıç Sayfası";
});

Route::group([], function () {
    // auth routes
    Route::group(['prefix' => 'auth', 'name' => 'auth.', 'controller' => LoginController::class], function () {
        Route::get('{provider}/callback', 'callback')->name('callback');
        Route::get('google', 'withGoogle')->name('google');
    });
    // other routes...
});
