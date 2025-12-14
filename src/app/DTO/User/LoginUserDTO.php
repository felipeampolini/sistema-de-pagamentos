<?php

namespace App\DTO\User;

readonly class LoginUserDTO
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}
