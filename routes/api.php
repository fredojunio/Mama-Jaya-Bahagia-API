<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\CashbackController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\IncomeController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ReportRitController;
use App\Http\Controllers\Api\RitBranchController;
use App\Http\Controllers\Api\RitController;
use App\Http\Controllers\Api\RitTransactionController;
use App\Http\Controllers\Api\SavingController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\VehicleController;
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
    Route::apiResource('cashback', CashbackController::class);
    Route::apiResource('customer', CustomerController::class);
    Route::post('/customer/search', [CustomerController::class, 'search']);
    Route::post('/customer/{customer}/withdraw_savings', [CustomerController::class, 'withdraw_savings']);
    Route::post('/customer/{customer}/approve_cashback', [CustomerController::class, 'approve_cashback']);
    Route::apiResource('vehicle', VehicleController::class);
    Route::post('/vehicle/search', [VehicleController::class, 'search']);
    Route::apiResource('rit', RitController::class);
    Route::apiResource('ritbranch', RitBranchController::class);
    Route::apiResource('trip', TripController::class);
    Route::apiResource('rit_transaction', RitTransactionController::class);
    Route::apiResource('transaction', TransactionController::class);
    Route::apiResource('saving', SavingController::class);
    Route::apiResource('report', ReportController::class);
    Route::apiResource('income', IncomeController::class);
    Route::apiResource('expense', ExpenseController::class);
    Route::apiResource('report_rit', ReportRitController::class);
});
