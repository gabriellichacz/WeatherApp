<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/store', [App\Http\Controllers\HomeController::class, 'store']);

//
Route::get('/details/{city}', [App\Http\Controllers\DetailsController::class, 'details'])->name('details.show');