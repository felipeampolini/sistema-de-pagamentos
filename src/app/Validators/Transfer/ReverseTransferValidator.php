<?php

namespace App\Validators\Transfer;

use App\Models\Transfer;
use RuntimeException;

class ReverseTransferValidator
{
    /**
     * Valida se uma transferencia pode ser revertida
     * @param Transfer $transfer
     * @param int $receiverId
     * @throws RuntimeException
     * @return void
     */
    public function validate(Transfer $transfer, int $receiverId): void
    {

        if (!$transfer) {
            throw new RuntimeException('Transferência não encontrada.');
        }

        if ($transfer->receiver_id !== $receiverId) {
            throw new RuntimeException('Apenas o recebedor pode estornar esta transferência.');
        }

        if ($transfer->status === 'reversed') {
            throw new RuntimeException('Esta transferência já foi estornada.');
        }

        if ($transfer->status !== 'completed') {
            throw new RuntimeException('A transferência não pode ser estornada.');
        }
    }
}
