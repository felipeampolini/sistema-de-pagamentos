<?php

namespace App\Actions\User;

use App\DTO\User\CreateUserDTO;
use App\Repositories\UserRepository;
use App\Validators\User\CreateUserValidator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CreateUserAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository, private CreateUserValidator $validator)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Executa a ação de criar um usuário
     *
     * @param CreateUserDTO $dto
     * @return \App\Models\User
     * @throws ValidationException
     */
    public function execute(CreateUserDTO $dto)
    {

        // Validação dupla por garantia, Caso passe pelo CreateUserRequest, valido por aqui também.
        $this->validator->validate($this->userRepository, $dto);

        // Cria o usuário
        return $this->userRepository->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'cpf_cnpj' => $dto->cpf_cnpj,
            'password' => Hash::make($dto->password),
            'balance' => $dto->balance,
            'type' => $dto->type,
            'phone' => $dto->phone
        ]);
    }
}
