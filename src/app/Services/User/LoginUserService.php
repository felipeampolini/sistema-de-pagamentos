<?php

namespace App\Services\User;

use App\DTO\User\LoginUserDTO;
use App\Actions\User\LoginUserAction;
use App\Models\User;

class LoginUserService
{
    private LoginUserAction $action;

    public function __construct(LoginUserAction $action)
    {
        $this->action = $action;
    }

    public function execute(LoginUserDTO $dto): User
    {
        return $this->action->execute($dto);
    }
}
