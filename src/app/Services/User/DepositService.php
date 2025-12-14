<?php

namespace App\Services\User;

use App\Actions\User\DepositAction;
use App\Models\User;

class DepositService
{
    private DepositAction $action;

    public function __construct(DepositAction $action)
    {
        $this->action = $action;
    }

    public function execute(User $user, float $amount): User
    {
        return $this->action->execute($user, $amount);
    }
}
