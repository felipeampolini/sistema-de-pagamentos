<?php

namespace App\Validators\User;

use App\Models\User;
use RuntimeException;

class WithdrawValidator
{
    public function validate(User $user, float $amount): void
    {
        if ($user->balance < $amount) {
            throw new RuntimeException('Saldo insuficiente para realizar o saque.');
        }
    }
}
