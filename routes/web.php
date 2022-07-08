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
Route::get('/choose', [App\Http\Controllers\HomeController::class, 'choose']);
Route::post('/store', [App\Http\Controllers\HomeController::class, 'store']);
Route::get('/test', [App\Http\Controllers\HomeController::class, 'test']);