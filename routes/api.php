<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'admin'], function() {
    Route::post('/login', [AdminController::class, 'login']);

    Route::group(['middleware' => ['jwt.admin']], function () {
        Route::post('/logout', [AdminController::class, 'logout']);
        Route::post('/filter', [AdminController::class, 'filter']);
        Route::post('/registeredUsers', [AdminController::class, 'registeredUsers']);
        Route::get('/getUsers', [AdminController::class, 'getUsers']);
    });
});

Route::group(['prefix' => 'user'], function() {
    Route::post('/register', [UserController::class, 'register']);
});
