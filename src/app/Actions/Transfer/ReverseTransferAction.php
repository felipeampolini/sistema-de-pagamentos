<?php

namespace App\Actions\Transfer;

use App\DTO\Transfer\ReverseTransferDTO;
use App\Models\Transfer;
use App\Models\User;
use App\Repositories\TransferRepository;
use App\Validators\Transfer\ReverseTransferValidator;
use Illuminate\Support\Facades\DB;
use RuntimeException;

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
        $this->validator->validate($transfer, $dto->receiver_id);

        return DB::transaction(function () use ($transfer) {

            $transfer->status = 'reversed';
            $transfer->reversed_at = now();
            $transfer->save();

            $sender = User::find($transfer->sender_id);
            $sender->balance += $transfer->amount;
            $sender->save();

            return $transfer;
        });
    }
}
