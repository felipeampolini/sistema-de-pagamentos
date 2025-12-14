<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class DepositAction
{
    public function execute(User $user, float $amount): User
    {
        return DB::transaction(function () use ($user, $amount) {

            $user->balance += $amount;
            $user->save();

            return $user;
        });
    }
}
