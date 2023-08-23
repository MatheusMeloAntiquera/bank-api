<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
