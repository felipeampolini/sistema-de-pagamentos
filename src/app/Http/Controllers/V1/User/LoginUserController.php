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
