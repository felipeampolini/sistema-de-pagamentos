<?php

namespace App\Services\User;

use App\Actions\User\WithdrawAction;
use App\Models\User;

class WithdrawService
{
    private WithdrawAction $action;

    public function __construct(WithdrawAction $action)
    {
        $this->action = $action;
    }

    public function execute(User $user, float $amount): User
    {
        return $this->action->execute($user, $amount);
    }
}
