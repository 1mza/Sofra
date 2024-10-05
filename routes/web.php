<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\ContactLinkController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NeighbourhoodController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SettingsTextController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get('/', function () {
        return view('landing-page');
    });
});


Route::group(['prefix' => 'admin-panel', 'middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/home', [HomeController::class, 'home'])->name('home');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('cities', CityController::class);
    Route::resource('neighbourhoods', NeighbourhoodController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('commissions', CommissionController::class);
    Route::resource('offers', OfferController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('contacts', ContactUsController::class);
    Route::resource('settings', SettingsTextController::class);
    Route::resource('sellers', SellerController::class);
    Route::resource('clients', ClientController::class);

    Route::resource('users', UserController::class);

//    Route::get('/users', [UserController::class, 'index'])->middleware('can:viewAny,App\Models\User');


    Route::resource('payment-methods', PaymentMethodController::class);
    Route::resource('contact-links', ContactLinkController::class);
    Route::resource('products', ProductController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);


    // Fallback route for undefined routes
    Route::fallback(function () {
        abort(404);
    });
});


require __DIR__ . '/auth.php';
