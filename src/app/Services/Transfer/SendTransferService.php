<?php

namespace App\Services\Transfer;

use App\DTO\Transfer\SendTransferDTO;
use App\Actions\Transfer\SendTransferAction;
use App\Models\Transfer;
use App\Models\User;
use App\Validators\Transfer\SendTransferValidator;

class SendTransferService
{

    public function __construct(
        private SendTransferAction $action,
        private SendTransferValidator $validator
    ) {
    }

    public function execute(SendTransferDTO $dto): Transfer
    {
        $sender = User::findOrFail($dto->sender_id);
        $receiver = User::findOrFail($dto->receiver_id);

        $this->validator->validate($dto, $sender, $receiver);

        return $this->action->execute($dto);
    }
}
