<?php

namespace App\DTO\User;

readonly class RegisterUserDTO
{
    public function __construct(
        public string $name,
        public string $cpf_cnpj,
        public string $email,
        public string $password,
        public float $balance,
        public string $type // 'common' ou 'merchant'
    ) {}
}
