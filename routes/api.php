<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CustomerTypeController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\IncomeController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ReportRitController;
use App\Http\Controllers\Api\RitBranchController;
use App\Http\Controllers\Api\RitTransactionController;
use App\Http\Controllers\Api\SavingController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\VehicleTypeController;
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
    Route::apiResource('customer', CustomerController::class);
    Route::post('/customer/search', [CustomerController::class, 'search']);
    Route::apiResource('vehicle', VehicleController::class);
    Route::post('/vehicle/search', [VehicleController::class, 'search']);
    Route::apiResource('rit', RitController::class);
    Route::apiResource('ritbranch', RitBranchController::class);
    Route::apiResource('Trip', TripController::class);
    Route::apiResource('RitTransaction', RitTransactionController::class);
    Route::apiResource('Transaction', TransactionController::class);
    Route::apiResource('Saving', SavingController::class);
    Route::apiResource('Report', ReportController::class);
    Route::apiResource('Income', IncomeController::class);
    Route::apiResource('Expense', ExpenseController::class);
    Route::apiResource('ReportRit', ReportRitController::class);
});
