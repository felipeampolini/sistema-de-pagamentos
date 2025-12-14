<?php

namespace App\Validators\Transfer;

use App\DTO\Transfer\SendTransferDTO;
use App\Models\User;
use DomainException;

class SendTransferValidator
{
    /**
     * Valida se uma transferencia pode ser efetuada
     * @param SendTransferDTO $dto
     * @param User $sender
     * @param User $receiver
     * @return void
     */
    public function validate(
        SendTransferDTO $dto,
        User $sender,
        User $receiver
    ): void {

        if ($sender->type === 'merchant') {
            throw new DomainException(
                'Usuários lojistas não podem realizar transferências.'
            );
        }

        if ($sender->id === $receiver->id) {
            throw new DomainException(
                'Usuário não pode transferir dinheiro para si mesmo.'
            );
        }

        if ($sender->balance < $dto->amount) {
            throw new DomainException(
                'Saldo insuficiente para realizar a transferência.'
            );
        }
    }
}
