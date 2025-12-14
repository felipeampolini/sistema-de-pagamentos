<?php

namespace App\Actions\Transfer;

use App\DTO\Transfer\ReverseTransferDTO;
use App\Models\Transfer;
use App\Models\User;
use App\Repositories\TransferRepository;
use App\Validators\Transfer\ReverseTransferValidator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReverseTransferAction
{
    private ReverseTransferValidator $validator;
    private TransferRepository $transferRepository;

    public function __construct(
        ReverseTransferValidator $validator,
        TransferRepository $transferRepository
    ) {
        $this->validator = $validator;
        $this->transferRepository = $transferRepository;
    }

    public function execute(ReverseTransferDTO $dto): Transfer
    {

        $transfer = $this->transferRepository->find($dto->transfer_id);
        $sender = User::find($transfer->sender_id);
        $receiver = User::find($transfer->receiver_id);

        $this->validator->validate($transfer, $receiver);

        return DB::transaction(function () use ($transfer, $sender, $receiver) {

            $transfer->status = 'reversed';
            $transfer->reversed_at = now();
            $transfer->save();

            $amount = (float)$transfer->amount;

            $sender->balance += $amount;
            $sender->save();

            $receiver->balance -= $amount;
            $receiver->save();

            Log::channel('transfer')->info('Estorno realizado', [
                'Estornado do usuario' => $receiver->id,
                'para o usuario' => $sender->id,
                'valor' => $amount
            ]);

            return $transfer;
        });
    }
}
