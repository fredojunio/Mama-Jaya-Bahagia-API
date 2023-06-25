<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\CasController;
use App\Http\Controllers\Api\CasDepositController;
use App\Http\Controllers\Api\CashbackController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\IncomeController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\NotificationController;
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

//TODO - KASIH MIDDLEWARE AUTH:API KALAU UDAH SELESAI
Route::group(['prefix' => 'admin'], function () {
    Route::get('get_notification', [NotificationController::class, 'get_notification']);
    Route::get('/rit/get_all_stock', [RitController::class, 'get_all_stock']);
    Route::get('/rit/get_sell_owner_stock', [RitController::class, 'get_sell_owner_stock']);
    Route::get('/rit/get_created_stock', [RitController::class, 'get_created_stock']);
    Route::get('/rit/get_otw_stock', [RitController::class, 'get_otw_stock']);
    Route::get('/rit/get_owner_stock', [RitController::class, 'get_owner_stock']);
    Route::get('/rit/get_hold_stock', [RitController::class, 'get_hold_stock']);
    Route::post('/rit/get_empty_stock', [RitController::class, 'get_empty_stock']);
    Route::apiResource('item', ItemController::class);
    Route::apiResource('cashback', CashbackController::class);
    Route::get('/customer/get_lean_data', [CustomerController::class, 'get_lean_data']);
    Route::apiResource('customer', CustomerController::class);
    Route::post('/customer/search', [CustomerController::class, 'search']);
    Route::post('/customer/{customer}/get_customer_transactions', [CustomerController::class, 'get_customer_transactions']);
    Route::post('/customer/{customer}/get_customer_savings', [CustomerController::class, 'get_customer_savings']);
    Route::post('/customer/{customer}/deposit_savings', [CustomerController::class, 'deposit_savings']);
    Route::post('/customer/{customer}/withdraw_savings', [CustomerController::class, 'withdraw_savings']);
    Route::post('/customer/{customer}/approve_cashback', [CustomerController::class, 'approve_cashback']);
    Route::apiResource('vehicle', VehicleController::class);
    Route::post('/vehicle/{vehicle}/get_vehicle_trips', [VehicleController::class, 'get_vehicle_trips']);
    Route::post('/vehicle/search', [VehicleController::class, 'search']);
    Route::apiResource('rit', RitController::class);
    Route::get('/rit/{rit}/reject_finance', [RitController::class, 'reject_finance']);
    Route::get('/rit/{rit}/approve_finance', [RitController::class, 'approve_finance']);
    Route::post('/rit/{rit}/arrived', [RitController::class, 'arrived']);
    Route::post('/rit/{rit}/priced', [RitController::class, 'priced']);
    Route::post('/rit/transfer_to_branch', [RitController::class, 'transfer_to_branch']);
    Route::post('/rit/{rit}/transfer_from_branch', [RitController::class, 'transfer_from_branch']);
    Route::post('/rit/{rit}/return', [RitController::class, 'return']);
    Route::apiResource('ritbranch', RitBranchController::class);
    Route::apiResource('trip', TripController::class);
    Route::get('/trip/{trip}/surat_jalan/', [TripController::class, 'surat_jalan']);
    Route::apiResource('rit_transaction', RitTransactionController::class);
    Route::post('/transaction/get_completed_transactions', [TransactionController::class, 'get_completed_transactions']);
    Route::get('/transaction/get_remaining_sack', [TransactionController::class, 'get_remaining_sack']);
    Route::get('/transaction/get_owner_nota', [TransactionController::class, 'get_owner_nota']);
    Route::get('/transaction/get_owner_transactions', [TransactionController::class, 'get_owner_transactions']);
    Route::get('/transaction/get_requested_revisions', [TransactionController::class, 'get_requested_revisions']);
    Route::post('/transaction/{transaction}/request_revision/', [TransactionController::class, 'request_revision']);
    Route::get('/transaction/{transaction}/approve_revision/', [TransactionController::class, 'approve_revision']);
    Route::apiResource('transaction', TransactionController::class);
    Route::post('/transaction/get_nota', [TransactionController::class, 'get_nota']);
    Route::post('/transaction/{transaction}/approve_finance', [TransactionController::class, 'approve_finance']);
    Route::post('/transaction/{transaction}/approve_nota', [TransactionController::class, 'approve_nota']);
    Route::post('/transaction/{transaction}/customer', [TransactionController::class, 'customer']);
    Route::post('/transaction/{rit}/branch', [TransactionController::class, 'branch']);
    Route::post('/saving/get_savings_incomes', [SavingController::class, 'get_savings_incomes']);
    Route::apiResource('saving', SavingController::class);
    Route::get('/report/create_daily_report', [ReportController::class, 'create_daily_report']);
    Route::get('/report/check_daily_report', [ReportController::class, 'check_daily_report']);
    Route::get('/report/get_today_report', [ReportController::class, 'get_today_report']);
    Route::post('/report/get_monthly_report', [ReportController::class, 'get_monthly_report']);
    Route::apiResource('report', ReportController::class);
    Route::apiResource('income', IncomeController::class);
    Route::post('/expense/filter', [ExpenseController::class, 'filter']);
    Route::apiResource('expense', ExpenseController::class);
    Route::apiResource('report_rit', ReportRitController::class);
    Route::apiResource('cas_deposit', CasDepositController::class);
    Route::post('/cas/get_cas', [CasController::class, 'get_cas']);
    Route::apiResource('cas', CasController::class);
});
