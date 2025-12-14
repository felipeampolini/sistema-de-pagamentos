<?php

use App\Http\Controllers\V1\Transfer\ReverseTransferController;
use App\Http\Controllers\V1\Transfer\SendTransferController;
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

    Route::prefix('users')->group(function () {
        Route::get('/my-balance', MyBalanceController::class);
        Route::post('/deposit', DepositController::class);
        Route::post('/withdraw', WithdrawController::class);
    });

    Route::prefix('transfer')->group(function () {
        Route::post('/send', SendTransferController::class);
        Route::post('/reverse', ReverseTransferController::class);
    });

});
