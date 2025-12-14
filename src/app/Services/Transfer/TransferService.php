<?php

namespace App\Services\Transfer;

use App\DTO\Transfer\TransferDTO;
use App\Actions\Transfer\CreateTransferAction;
use App\Models\Transfer;
use App\Models\User;
use App\Validators\Transfer\TransferValidator;

class TransferService
{
    private CreateTransferAction $action;
    private TransferValidator $validator;

    public function __construct(
        CreateTransferAction $action,
        TransferValidator $validator
    ) {
        $this->action = $action;
        $this->validator = $validator;
    }

    public function execute(TransferDTO $dto): Transfer
    {
        $sender = User::findOrFail($dto->sender_id);
        $receiver = User::findOrFail($dto->receiver_id);

        $this->validator->validate($dto, $sender, $receiver);

        return $this->action->execute($dto);
    }
}
