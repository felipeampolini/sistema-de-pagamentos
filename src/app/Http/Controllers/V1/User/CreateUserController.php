<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Services\User\CreateUserService;
use Illuminate\Http\JsonResponse;

class CreateUserController extends Controller
{
    private CreateUserService $CreateUserService;

    public function __construct(CreateUserService $CreateUserService)
    {
        $this->CreateUserService = $CreateUserService;
    }

    /**
     * Endpoint para registrar um novo usuário
     */
    public function __invoke(CreateUserRequest $request): JsonResponse
    {
        $dto = $request->toDTO();
        $user = $this->CreateUserService->register($dto);

        return response()->json([
            'message' => 'Usuário registrado com sucesso!',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'cpf_cnpj' => $user->cpf_cnpj,
                'type' => $user->type,
                'phone' => $user->phone,
                'balance' => $user->balance,
                'created_at' => $user->created_at,
            ],
        ], 201);
    }
}
