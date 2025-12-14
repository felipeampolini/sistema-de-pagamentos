<?php

namespace App\Http\Requests\User;

use App\DTO\User\CreateUserDTO;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{

    /**
     * Regras de validação.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'cpf_cnpj' => ['required', 'string', 'max:20', 'unique:users,cpf_cnpj'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'balance' => ['required', 'numeric', 'min:0'],
            'type' => ['required', 'string', 'in:common,merchant'],
            'phone' => ['required', 'string', 'max:255']
        ];
    }

    /**
     * Converte a request em DTO.
     */
    public function toDTO(): CreateUserDTO
    {
        return new CreateUserDTO(
            name: $this->input('name'),
            cpf_cnpj: $this->input('cpf_cnpj'),
            email: $this->input('email'),
            password: $this->input('password'),
            balance: (float) $this->input('balance'),
            type: $this->input('type'),
            phone: $this->input('phone')
        );
    }
}
