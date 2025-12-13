<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    private User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Cria um novo usuário
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    /**
     * Verifica se já existe um usuário com o mesmo email
     *
     * @param string $email
     * @return bool
     */
    public function existsByEmail(string $email): bool
    {
        return $this->model->where('email', $email)->exists();
    }

    /**
     * Verifica se já existe um usuário com o mesmo CPF/CNPJ
     *
     * @param string $cpfCnpj
     * @return bool
     */
    public function existsByCpfCnpj(string $cpfCnpj): bool
    {
        return $this->model->where('cpf_cnpj', $cpfCnpj)->exists();
    }

    /**
     * Encontra um usuário pelo ID
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return $this->model->find($id);
    }
}
