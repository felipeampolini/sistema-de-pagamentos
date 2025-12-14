<?php

namespace App\Actions\Transfer;

use App\DTO\Transfer\TransferDTO;
use App\Models\User;
use App\Models\Transfer;
use Illuminate\Support\Facades\DB;
use Exception;

class CreateTransferAction
{
    /**
     * Executa a transferência.
     *
     * @throws Exception se houver saldo insuficiente ou falha na autorização
     */
    public function execute(TransferDTO $dto): Transfer
    {
        // Recupera remetente e destinatário
        $sender = $dto->sender_id ? User::findOrFail($dto->sender_id) : null;
        $receiver = User::findOrFail($dto->receiver_id);

        // Validação: remetente não pode enviar mais que o saldo disponível
        if ($sender && $sender->balance < $dto->amount) {
            throw new Exception("Saldo insuficiente para realizar a transferência.");
        }

        // Mock de serviço externo de autorização
        if (!$this->authorizeExternal()) {
            throw new Exception("Transferência não autorizada pelo serviço externo.");
        }

        // Transação DB para garantir atomicidade
        return DB::transaction(function () use ($sender, $receiver, $dto) {
            if ($sender) {
                $sender->balance -= $dto->amount;
                $sender->save();
            }

            $receiver->balance += $dto->amount;
            $receiver->save();

            $transfer = Transfer::create([
                'sender_id' => $sender?->id,
                'receiver_id' => $receiver->id,
                'amount' => $dto->amount,
                'status' => 'completed',
            ]);

            // Mock de notificação (pode ser log ou e-mail simulado)
            $this->notifyUsers($sender, $receiver, $dto->amount);

            return $transfer;
        });
    }

    /**
     * Simula serviço externo de autorização
     */
    private function authorizeExternal(): bool
    {
        // Retorna sempre true para o mock
        return true;
    }

    /**
     * Simula notificação para remetente e destinatário
     */
    private function notifyUsers(?User $sender, User $receiver, float $amount): void
    {
        if ($sender) {
            // Simulação: log ou print
            logger("Notificação: {$sender->name} enviou R$ {$amount} para {$receiver->name}");
        }

        logger("Notificação: {$receiver->name} recebeu R$ {$amount}" . ($sender ? " de {$sender->name}" : ""));
    }
}
