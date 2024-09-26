<?php

use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\NeighbourhoodController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1'], function () {

    Route::get('/cities', [CityController::class, 'index']);
    Route::get('/neighbourhoods', [NeighbourhoodController::class, 'index']);

    Route::group(['prefix' => 'clients'], function () {
        Route::post('/register', [App\Http\Controllers\API\Client\AuthController::class, 'register']);
        Route::post('/login', [App\Http\Controllers\API\Client\AuthController::class, 'login']);
        Route::post('/reset-password', [App\Http\Controllers\API\Client\AuthController::class, 'resetPassword']);
        Route::post('/new-password', [App\Http\Controllers\API\Client\AuthController::class, 'newPassword']);
        Route::post('/register-token', [App\Http\Controllers\API\Client\AuthController::class, 'registerToken']);

        Route::group(['middleware' => 'auth:api-clients'], function () {
            Route::post('/logout', [App\Http\Controllers\API\Client\AuthController::class, 'logout']);
        });


    });

    Route::group(['prefix' => 'sellers'], function () {
        Route::post('/register', [App\Http\Controllers\API\Seller\AuthController::class, 'register']);
        Route::post('/login', [App\Http\Controllers\API\Seller\AuthController::class, 'login']);
        Route::post('/reset-password', [App\Http\Controllers\API\Seller\AuthController::class, 'resetPassword']);
        Route::post('/new-password', [App\Http\Controllers\API\Seller\AuthController::class, 'newPassword']);

        Route::group(['middleware' => 'auth:api-sellers'], function () {
            Route::post('/logout', [App\Http\Controllers\API\Seller\AuthController::class, 'logout']);
        });

    });
});