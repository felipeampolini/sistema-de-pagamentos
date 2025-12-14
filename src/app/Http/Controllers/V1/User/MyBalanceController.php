<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MyBalanceController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            'balance' => $user->balance,
        ]);
    }
}
