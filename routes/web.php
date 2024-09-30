<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NeighbourhoodController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group([],function () {
    Route::get('/', function () {
        return view('landing-page');
    });
});


Route::group(['prefix' => 'admin-panel','middleware' => 'auth'],function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/home',[HomeController::class,'home'])->name('home');

//    Route::get('/dashboard', function () {
//        return view('dashboard');
//    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::resource('cities', CityController::class);
        Route::resource('neighbourhoods', NeighbourhoodController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('commissions', CommissionController::class);
        Route::resource('offers', OfferController::class);
    });
});


require __DIR__.'/auth.php';
