<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterUserRequest;
use App\Services\User\RegisterUserService;
use Illuminate\Http\JsonResponse;

class RegisterUserController extends Controller
{
    private RegisterUserService $registerUserService;

    public function __construct(RegisterUserService $registerUserService)
    {
        $this->registerUserService = $registerUserService;
    }

    /**
     * Endpoint para registrar um novo usuário
     */
    public function __invoke(RegisterUserRequest $request): JsonResponse
    {
        $dto = $request->toDTO();
        $user = $this->registerUserService->register($dto);

        return response()->json([
            'message' => 'Usuário registrado com sucesso!',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'cpf_cnpj' => $user->cpf_cnpj,
                'type' => $user->type,
                'balance' => $user->balance,
                'created_at' => $user->created_at,
            ],
        ], 201);
    }
}
