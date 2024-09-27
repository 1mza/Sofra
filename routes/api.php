<?php

use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\NeighbourhoodController;
use App\Http\Controllers\API\Client\ClientController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\Seller\SellerController;
use App\Http\Controllers\API\Seller\OfferController;
use App\Http\Controllers\API\Seller\ProductController;
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
            Route::patch('/update-profile', [ClientController::class, 'profile']);


        });
    });

    Route::group(['prefix' => 'sellers'], function () {
        Route::post('/register', [App\Http\Controllers\API\Seller\AuthController::class, 'register']);
        Route::post('/login', [App\Http\Controllers\API\Seller\AuthController::class, 'login']);
        Route::post('/reset-password', [App\Http\Controllers\API\Seller\AuthController::class, 'resetPassword']);
        Route::post('/new-password', [App\Http\Controllers\API\Seller\AuthController::class, 'newPassword']);
        Route::get('/categories', [App\Http\Controllers\API\Seller\SellerController::class, 'categories']);

        Route::group(['middleware' => 'auth:api-sellers'], function () {
            Route::post('/logout', [App\Http\Controllers\API\Seller\AuthController::class, 'logout']);
            Route::patch('/update-profile', [SellerController::class, 'profile']);

            Route::get('products', [ProductController::class,'index']);
            Route::patch('products/{product}', [ProductController::class,'updateProduct']);
            Route::post('products/{product}', [ProductController::class,'createProduct']);
            Route::delete('products/{product}', [ProductController::class,'deleteProduct']);

            Route::get('offers', [OfferController::class,'index']);
            Route::patch('offers/{offer}', [OfferController::class,'updateOffer']);
            Route::post('offers/{offer}', [OfferController::class,'createOffer']);
            Route::delete('offers/{offer}', [OfferController::class,'deleteOffer']);

            Route::post('new-orders', [OrderController::class,'newOrders']);
            Route::post('current-orders', [OrderController::class,'currentOrders']);
            Route::get('past-orders', [OrderController::class,'pastOrders']);

            Route::post('pay-commission', [SellerController::class,'payCommission']);
            Route::get('commissions', [SellerController::class,'commissionInfo']);


        });
    });
});