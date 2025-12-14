<?php

namespace App\Validators\User;

use App\DTO\User\CreateUserDTO;
use App\Repositories\UserRepository;
use Illuminate\Validation\ValidationException;

class CreateUserValidator
{
    public function validate(UserRepository $userRepository, CreateUserDTO $dto): void
    {
        // Verifica se email ou CPF/CNPJ já existem
        if ($userRepository->existsByEmail($dto->email)) {
            throw ValidationException::withMessages(['email' => 'Este e-mail já está em uso.']);
        }

        if ($userRepository->existsByCpfCnpj($dto->cpf_cnpj)) {
            throw ValidationException::withMessages(['cpf_cnpj' => 'Este CPF/CNPJ já está em uso.']);
        }
    }
}
