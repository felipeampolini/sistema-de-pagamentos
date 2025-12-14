<?php

namespace App\Validators\Transfer;

use App\Models\Transfer;
use App\Models\User;
use RuntimeException;

class ReverseTransferValidator
{
    /**
     * Valida se uma transferencia pode ser revertida
     * @param Transfer $transfer
     * @param User $receiver
     * @throws RuntimeException
     * @return void
     */
    public function validate(Transfer $transfer, User $receiver): void
    {

        if (!$transfer) {
            throw new RuntimeException('Transferência não encontrada.');
        }

        if ($transfer->receiver_id !== $receiver->id) {
            throw new RuntimeException('Apenas o recebedor pode estornar esta transferência.');
        }

        if ($receiver->balance - $transfer->amount <= 0) {
            throw new RuntimeException('Não há saldo suficiente para estornar essa transferência.');
        }

        if ($transfer->status === 'reversed') {
            throw new RuntimeException('Esta transferência já foi estornada.');
        }

        if ($transfer->status !== 'completed') {
            throw new RuntimeException('A transferência não pode ser estornada.');
        }
    }
}
