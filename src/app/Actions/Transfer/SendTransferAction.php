<?php

namespace App\Actions\Transfer;

use App\DTO\Transfer\SendTransferDTO;
use App\Models\User;
use App\Models\Transfer;
use App\Services\Notifiers\NotifierInterface;
use App\Validators\Transfer\SendTransferValidator;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Services\Authorizers\AuthorizerInterface;
use Illuminate\Support\Facades\Log;

class SendTransferAction
{
    private AuthorizerInterface $authorizer;
    private NotifierInterface $notifier;
    private SendTransferValidator $validator;

    public function __construct(AuthorizerInterface $authorizer, NotifierInterface $notifier, SendTransferValidator $validator)
    {
        $this->authorizer = $authorizer;
        $this->notifier = $notifier;
        $this->validator = $validator;
    }

    /**
     * Executa a transferência.
     *
     * @throws Exception se houver saldo insuficiente ou falha na autorização
     */
    public function execute(SendTransferDTO $dto): Transfer
    {
        $sender = User::findOrFail($dto->sender_id);
        $receiver = User::findOrFail($dto->receiver_id);

        $this->validator->validate($dto, $sender, $receiver);

        // Authorize é uma interface, que permite multiplas opcoes de autorizacoes
        if (!$this->authorizer->authorize($dto->amount, $dto->sender_id, $dto->receiver_id)) {
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

            $this->notifyUsers($sender, $receiver, $dto->amount);

            Log::channel('transfer')->info('Transferência realizada', [
                'Transferido do usuario' => $sender->id,
                'para o usuario' => $receiver->id,
                'valor' => $dto->amount
            ]);

            return $transfer;
        });
    }

    /**
     * Notifica os envolvidos que a transação foi feita
     * @param User $sender
     * @param User $receiver
     * @param float $amount
     * @return void
     */
    private function notifyUsers(User $sender, User $receiver, float $amount): void
    {
        $amount = number_format($amount, 2, ',', '.');

        $messageToSender = "Você transferiu R$ " . $amount . " para o usuário " . $receiver->name;
        $messageToReceiver = "Você recebeu uma transferencia de R$ ".$amount." do usuário ".$sender->name;

        $this->notifier->notify($sender->id, $messageToSender);
        $this->notifier->notify($receiver->id, $messageToReceiver);
    }
}
