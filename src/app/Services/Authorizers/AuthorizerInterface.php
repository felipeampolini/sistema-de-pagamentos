<?php

namespace App\Services\Authorizers;

interface AuthorizerInterface
{
    public function authorize(float $amount, int $senderId, int $receiverId): bool;
}
