<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0.01']
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'O valor do depósito é obrigatório.',
            'amount.numeric' => 'O valor do depósito deve ser numérico.',
            'amount.min' => 'O valor do depósito deve ser maior que zero.'
        ];
    }
}
