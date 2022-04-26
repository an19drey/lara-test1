<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\V1\UserController as UserController;
use \App\Http\Controllers\Api\V1\UserDetailsController as UserDetailsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('users', [UserController::class, 'create'])
    ->middleware(['api_version']);

Route::put('users/{userId}', [UserController::class, 'update'])
    ->middleware(['api_version']);

Route::get('users/{country}', [UserController::class, 'getActive'])
    ->middleware(['api_version']);

Route::delete('users/{userId}', [UserController::class, 'delete'])
    ->middleware(['api_version']);

Route::post('user-details/{userId}', [UserDetailsController::class, 'create'])
    ->middleware(['api_version']);

Route::put('user-details/{userId}', [UserDetailsController::class, 'update'])
    ->middleware(['api_version']);

Route::delete('user-details/{userId}', [UserDetailsController::class, 'delete'])
    ->middleware(['api_version']);
