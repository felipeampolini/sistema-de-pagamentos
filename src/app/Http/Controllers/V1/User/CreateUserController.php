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
     * @OA\Post(
     *     path="/api/v1/users",
     *     summary="Criar usuário",
     *     tags={"Usuários"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password","cpf_cnpj","type","phone","balance"},
     *             @OA\Property(property="name", type="string", example="Felipe"),
     *             @OA\Property(property="email", type="string", example="felipe@email.com"),
     *             @OA\Property(property="password", type="string", example="123123123"),
     *             @OA\Property(property="cpf_cnpj", type="string", example="12312312312"),
     *             @OA\Property(
     *                 property="type",
     *                 type="string",
     *                 enum={"common","merchant"},
     *                 example="common"
     *             ),
     *             @OA\Property(property="phone", type="string", example="5549999999999"),
     *             @OA\Property(property="balance", type="number", example=0)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Usuário criado"),
     *     @OA\Response(response=422, description="Erro de validação")
     * )
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
