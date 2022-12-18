<?php

use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Support\Facades\Route;

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['middleware' => 'web', 'prefix' => 'v1'], function () {
    // auth routes
    Route::group(['prefix' => 'auth', 'name' => 'auth.', 'controller' => LoginController::class], function () {
        Route::get('{provider}/callback', 'callback')->name('callback');
        Route::get('google', 'withGoogle')->name('google');
    });
    // other routes...
});
