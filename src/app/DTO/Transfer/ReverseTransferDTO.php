<?php

namespace App\DTO\Transfer;

readonly class ReverseTransferDTO
{
    public function __construct(
        public int $transfer_id,
        public int $receiver_id
    ) {}
}
