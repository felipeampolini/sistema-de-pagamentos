<?php

namespace App\DTO\Transfer;

class SendTransferDTO
{
    public ?int $sender_id;
    public int $receiver_id;
    public float $amount;

    public function __construct(array $data)
    {
        $this->sender_id = $data['sender_id'] ?? null;
        $this->receiver_id = $data['receiver_id'];
        $this->amount = $data['amount'];
    }
}
