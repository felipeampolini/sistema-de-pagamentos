<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Requests\User\WithdrawRequest;
use App\Services\User\WithdrawService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class WithdrawController
{
    private WithdrawService $service;

    public function __construct(WithdrawService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users/withdraw",
     *     summary="Realizar saque",
     *     tags={"Usuários"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"amount"},
     *             @OA\Property(property="amount", type="number", example=50.00)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Saque realizado"),
     *     @OA\Response(response=422, description="Saldo insuficiente")
     * )
     */
    public function __invoke(WithdrawRequest $request): JsonResponse
    {
        $user = Auth::user();
        $amount = (float) $request->validated()['amount'];

        $updatedUser = $this->service->execute($user, $amount);

        return response()->json([
            'message' => 'Saque realizado com sucesso.',
            'balance' => $updatedUser->balance,
        ], 201);
    }
}
