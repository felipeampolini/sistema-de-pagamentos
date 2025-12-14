<?php

namespace App\Validators\Transfer;

use App\DTO\Transfer\TransferDTO;
use App\Models\User;
use DomainException;

class TransferValidator
{
    /**
     * Valida se uma transferencia pode ser efetuada
     * @param TransferDTO $dto
     * @param User $sender
     * @param User $receiver
     * @return void
     */
    public function validate(
        TransferDTO $dto,
        User $sender,
        User $receiver
    ): void {
        $this->senderMustBeCommon($sender);
        $this->cannotTransferToSelf($sender, $receiver);
        $this->senderMustHaveBalance($sender, $dto->amount);
    }

    /**
     * Valida se o usuario esta fazendo uma transferencia para si mesmo
     * @param User $sender
     * @param User $receiver
     * @throws DomainException
     * @return void
     */
    private function cannotTransferToSelf(User $sender, User $receiver): void
    {
        if ($sender->id === $receiver->id) {
            throw new DomainException(
                'Usuário não pode transferir dinheiro para si mesmo.'
            );
        }
    }

    /**
     * Valida se o usuario não é um lojista, pois lojistas nao podem fazer transferencias
     * @param User $sender
     * @throws DomainException
     * @return void
     */
    private function senderMustBeCommon(User $sender): void
    {
        if ($sender->type === 'merchant') {
            throw new DomainException(
                'Usuários lojistas não podem realizar transferências.'
            );
        }
    }

    /**
     * Valida se o usuario tem saldo na conta
     * @param User $sender
     * @param float $amount
     * @throws DomainException
     * @return void
     */
    private function senderMustHaveBalance(User $sender, float $amount): void
    {
        if ($sender->balance < $amount) {
            throw new DomainException(
                'Saldo insuficiente para realizar a transferência.'
            );
        }
    }
}
