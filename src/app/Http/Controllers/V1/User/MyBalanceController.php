<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MyBalanceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/users/my-balance",
     *     summary="Consultar saldo do usuário",
     *     tags={"Usuários"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Saldo atual",
     *         @OA\JsonContent(
     *             @OA\Property(property="balance", type="number", example=1500.50)
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autenticado")
     * )
     */
    public function __invoke(): JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            'balance' => $user->balance,
        ]);
    }
}
