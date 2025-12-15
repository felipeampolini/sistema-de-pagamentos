<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Requests\User\DepositRequest;
use App\Services\User\DepositService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DepositController
{
    private DepositService $service;

    public function __construct(DepositService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users/deposit",
     *     summary="Realizar depósito",
     *     tags={"Usuários"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"amount"},
     *             @OA\Property(property="amount", type="number", example=100.00)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Depósito realizado"),
     *     @OA\Response(response=422, description="Valor inválido")
     * )
     */
    public function __invoke(DepositRequest $request): JsonResponse
    {
        $user = Auth::user();
        $amount = (float) $request->validated()['amount'];

        $updatedUser = $this->service->execute($user, $amount);

        return response()->json([
            'message' => 'Depósito realizado com sucesso.',
            'balance' => $updatedUser->balance,
        ], 201);
    }
}
