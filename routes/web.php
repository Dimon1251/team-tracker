<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Route::post('/api/register', [\App\Http\Controllers\AuthController::class, 'register']);
//Route::post('/api/login', [\App\Http\Controllers\AuthController::class, 'login']);
//Route::post('/api/logout', [\App\Http\Controllers\AuthController::class, 'logout']);


Route::get('{any?}', fn () => view('app'))->where('any', '.*');

//Route::get('/', [\App\Http\Controllers\AuthController::class, 'login']);
