<?php

use App\Http\Controllers\PurchaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TransferController;

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

Route::prefix('user')->group(function () {
    Route::post('/', [UserController::class, 'create']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::get('/{id}', [UserController::class, 'findUserById']);
    Route::delete('/{id}', [UserController::class, 'delete']);
});

Route::prefix('store')->group(function () {
    Route::post('/', [StoreController::class, 'create']);
    Route::put('/{id}', [StoreController::class, 'update']);
    Route::get('/{id}', [StoreController::class, 'findStoreById']);
    Route::delete('/{id}', [StoreController::class, 'delete']);
});

Route::prefix('transfer')->group(function () {
    Route::post('/', [TransferController::class, 'executeTransfer']);
});

Route::prefix('purchase')->group(function () {
    Route::post('/', [PurchaseController::class, 'executePurchase']);
});
