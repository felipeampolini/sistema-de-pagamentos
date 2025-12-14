<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'O valor do saque é obrigatório.',
            'amount.numeric'  => 'O valor do saque deve ser numérico.',
            'amount.min'      => 'O valor do saque deve ser maior que zero.',
        ];
    }
}
