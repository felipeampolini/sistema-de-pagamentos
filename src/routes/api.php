<?php

use App\Http\Controllers\V1\Transfer\TransferController;
use App\Http\Controllers\V1\User\DepositController;
use App\Http\Controllers\V1\User\MyBalanceController;
use App\Http\Controllers\V1\User\WithdrawController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\User\CreateUserController;
use App\Http\Controllers\V1\User\LoginUserController;

Route::prefix('v1')->group(function () {
    Route::post('/users', CreateUserController::class);
    Route::post('/auth/login', LoginUserController::class);
});

Route::middleware(['api', 'auth:api'])->prefix('v1')->group(function () {
    Route::post('/transfer', TransferController::class);
    Route::get('/users/my-balance', MyBalanceController::class);
    Route::post('/users/deposit', DepositController::class);
    Route::post('/users/withdraw', WithdrawController::class);
});
