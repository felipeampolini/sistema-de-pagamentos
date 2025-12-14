<?php

namespace App\Actions\User;

use App\Models\User;
use App\Validators\User\WithdrawValidator;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class WithdrawAction
{
    public function __construct(
        private WithdrawValidator $validator
    ) {}

    public function execute(User $user, float $amount): User
    {
        return DB::transaction(function () use ($user, $amount) {

            $this->validator->validate($user, $amount);

            $user->balance -= $amount;
            $user->save();

            return $user;
        });
    }
}

