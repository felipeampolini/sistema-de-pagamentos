<?php

namespace App\Actions\User;

use App\Models\User;
use App\Validators\User\WithdrawValidator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class WithdrawAction
{
    public function __construct(
        private WithdrawValidator $validator
    ) {}

    public function execute(User $user, float $amount): User
    {
        $this->validator->validate($user, $amount);

        return DB::transaction(function () use ($user, $amount) {

            $user->balance -= $amount;
            $user->save();

            Log::channel('user')->info('Saque efetuado', [
                'Id' => $user->id,
                'nome' => $user->name,
                'valor' => $amount
            ]);

            return $user;
        });
    }
}

