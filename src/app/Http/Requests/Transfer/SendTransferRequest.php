<?php

namespace App\Http\Requests\Transfer;

use Illuminate\Foundation\Http\FormRequest;

class SendTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }
    
    public function rules(): array
    {
        return [
            'receiver_id' => ['required', 'integer', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
        ];
    }

    public function messages(): array
    {
        return [
            'receiver_id.required' => 'O ID do usuário recebedor é obrigatório.',
            'receiver_id.integer' => 'O ID do usuário recebedor deve ser numérico.',
            'receiver_id.exists' => 'O ID do usuário recebedor deve existir.',
            'amount.required' => 'O valor do saque é obrigatório.',
            'amount.numeric' => 'O valor do saque deve ser numérico.',
            'amount.min' => 'O valor do saque deve ser maior que zero.',
        ];
    }
}
