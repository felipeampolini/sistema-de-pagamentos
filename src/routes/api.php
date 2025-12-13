<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\User\RegisterUserController;
use App\Http\Controllers\V1\User\LoginUserController;

Route::prefix('v1')->group(function () {
    Route::post('/users/register', RegisterUserController::class);
    Route::post('/users/login', LoginUserController::class);
});
