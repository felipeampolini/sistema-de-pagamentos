<?php

namespace App\Services\User;

use App\Actions\User\CreateUserAction;
use App\DTO\User\CreateUserDTO;
use App\Models\User;

class CreateUserService
{
    private CreateUserAction $createUserAction;

    public function __construct(CreateUserAction $createUserAction)
    {
        $this->createUserAction = $createUserAction;
    }

    /**
     * Registra um novo usuário
     *
     * @param CreateUserDTO $dto
     * @return User
     */
    public function register(CreateUserDTO $dto): User
    {
        return $this->createUserAction->execute($dto);
    }
}
