<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('/home', [App\Http\Controllers\Api\TodolistController::class, 'index']);
        Route::get('/showAuthUser', [App\Http\Controllers\Api\UserController::class, 'showAuthUser']);
        Route::get('/profile', [App\Http\Controllers\Api\UserController::class, 'editUser']);
        Route::patch('/{user}', [App\Http\Controllers\Api\UserController::class, 'updateUser']);


        Route::group(['prefix' => 'todolist'], function () {
            Route::post('/', [App\Http\Controllers\Api\TodolistController::class, 'storeTodolist']);
            Route::get('/{todolist}', [App\Http\Controllers\Api\TodolistController::class, 'showTodolist']);
        });
    });
});

Route::group(['prefix' => 'users'], function () {
    Route::post('/register', [App\Http\Controllers\Api\UserController::class, 'register']);
});




// Route::middleware('auth:sanctum')->group(function () {
    // Route::get('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
// });
//     Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
