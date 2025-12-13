<?php

namespace App\Services\User;

use App\Actions\User\CreateUserAction;
use App\DTO\User\RegisterUserDTO;
use App\Models\User;

class RegisterUserService
{
    private CreateUserAction $createUserAction;

    public function __construct(CreateUserAction $createUserAction)
    {
        $this->createUserAction = $createUserAction;
    }

    /**
     * Registra um novo usuário
     *
     * @param RegisterUserDTO $dto
     * @return User
     */
    public function register(RegisterUserDTO $dto): User
    {
        // Aqui você pode adicionar regras de negócio extras, logs, eventos, etc.
        return $this->createUserAction->execute($dto);
    }
}
