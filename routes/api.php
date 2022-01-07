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
        Route::get('/checkToken', [AdminController::class, 'checkToken']);
        Route::post('/logout', [AdminController::class, 'logout']);
        Route::post('/filter', [AdminController::class, 'filter']);
        Route::post('/registeredUsers', [AdminController::class, 'registeredUsers']);
        Route::get('/getUsers', [AdminController::class, 'getUsers']);
        Route::get('/day', [AdminController::class, 'day']);
        Route::get('/week', [AdminController::class, 'week']);
        Route::get('/month', [AdminController::class, 'month']);
        Route::get('/month3', [AdminController::class, 'month3']);
        Route::get('/year', [AdminController::class, 'year']);
    });
});

Route::group(['prefix' => 'user'], function() {
    Route::post('/register', [UserController::class, 'register']);
});
