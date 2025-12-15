<?php

namespace App\Validators\User;

use App\DTO\User\LoginUserDTO;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginUserValidator
{
    public function validate($user, LoginUserDTO $dto): void
    {
        if (!$user || !Hash::check($dto->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email ou senha inválidos.'],
            ]);
        }
    }
}
