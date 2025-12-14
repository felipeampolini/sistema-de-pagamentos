<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\UserType;

class CreateUserRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer essa requisição.
     */
    public function authorize(): bool
    {
        return true; // cadastro aberto
    }

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
        ];
    }

    /**
     * Converte a request em DTO.
     */
    public function toDTO(): \App\DTO\User\CreateUserDTO
    {
        return new \App\DTO\User\CreateUserDTO(
            name: $this->input('name'),
            cpf_cnpj: $this->input('cpf_cnpj'),
            email: $this->input('email'),
            password: $this->input('password'),
            balance: (float) $this->input('balance'),
            type: $this->input('type'),
        );
    }
}
