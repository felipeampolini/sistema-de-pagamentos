<?php

namespace App\Actions\User;

use App\DTO\User\LoginUserDTO;
use App\Models\User;
use App\Validators\User\LoginUserValidator;

class LoginUserAction
{
    public function __construct(private LoginUserValidator $validator){
    }

    public function execute(LoginUserDTO $dto): User
    {
        $user = User::where('email', $dto->email)->first();

        $this->validator->validate($user, $dto);

        return $user;
    }
}
