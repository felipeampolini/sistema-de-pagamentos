<?php

namespace App\Services\Transfer;

use App\DTO\Transfer\ReverseTransferDTO;
use App\Actions\Transfer\ReverseTransferAction;
use App\Models\Transfer;

class ReverseTransferService
{
    private ReverseTransferAction $action;

    public function __construct(ReverseTransferAction $action)
    {
        $this->action = $action;
    }

    public function execute(ReverseTransferDTO $dto): Transfer
    {
        return $this->action->execute($dto);
    }
}
