<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepositAction
{
    public function execute(User $user, float $amount): User
    {
        return DB::transaction(function () use ($user, $amount) {

            $user->balance += $amount;
            $user->save();

            Log::channel('user')->info('Deposito efetuado', [
                'Id' => $user->id,
                'nome' => $user->name,
                'valor' => $amount
            ]);

            return $user;
        });
    }
}
