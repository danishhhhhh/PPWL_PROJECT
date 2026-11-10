<?php

use App\Http\Controllers\RentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

Auth::routes([
    'register' => false,
    'reset' => false,
]);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/rents', [RentController::class, 'index'])->name('rents.index');

Route::get('/rents/search', [RentController::class, 'search'])->name('rents.search');

Route::get('/rents/create', [RentController::class, 'create']);
Route::post('/rents', [RentController::class, 'store']);

Route::get('/rents/{id}/edit', [RentController::class, 'edit']);
Route::put('/rents/{id}', [RentController::class, 'update']);

Route::delete('/rents/{id}', [RentController::class, 'destroy']);

Route::resource('users', UserController::class)->except(['show']);

Route::get('/home', [HomeController::class, 'index'])->name('home');
