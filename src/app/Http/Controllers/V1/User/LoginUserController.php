<?php

namespace App\Http\Controllers\V1\User;

use App\DTO\User\LoginUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Services\User\LoginUserService;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginUserController extends Controller
{
    private LoginUserService $service;

    public function __construct(LoginUserService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     summary="Login do usuário",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login realizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Credenciais inválidas")
     * )
     */
    public function __invoke(LoginUserRequest $request)
    {

        $body = $request->validated();

        $dto = new LoginUserDTO($body["email"], $body["password"]);
        $user = $this->service->execute($dto);
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'type' => $user->type,
            'token' => $token
        ]);
    }
}
