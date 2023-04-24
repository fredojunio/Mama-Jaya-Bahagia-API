<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\ItemController;
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

Route::post('/login', [LoginController::class, 'login']);

Route::group(['middleware' => 'auth:api', 'as' => 'api.user.'], function () {
    Route::post('/logout', [LoginController::class, 'logout']);
});

//NOTE - KASIH MIDDLEWARE AUTH:API KALAU UDAH SELESAI
Route::group(['prefix' => 'admin'], function () {
    Route::apiResource('item', ItemController::class);
});
