<?php

namespace App\Actions\User;

use App\DTO\User\RegisterUserDTO;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CreateUserAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Executa a ação de criar um usuário
     *
     * @param RegisterUserDTO $dto
     * @return \App\Models\User
     * @throws ValidationException
     */
    public function execute(RegisterUserDTO $dto)
    {
        // Verifica se email ou CPF/CNPJ já existem
        if ($this->userRepository->existsByEmail($dto->email)) {
            throw ValidationException::withMessages(['email' => 'Este e-mail já está em uso.']);
        }

        if ($this->userRepository->existsByCpfCnpj($dto->cpf_cnpj)) {
            throw ValidationException::withMessages(['cpf_cnpj' => 'Este CPF/CNPJ já está em uso.']);
        }

        // Cria o usuário
        return $this->userRepository->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'cpf_cnpj' => $dto->cpf_cnpj,
            'password' => Hash::make($dto->password),
            'balance' => $dto->balance,
            'type' => $dto->type,
        ]);
    }
}
