<?php

namespace App\Http\Requests\Transfer;

use Illuminate\Foundation\Http\FormRequest;

class ReverseTransferRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'transfer_id' => ['required', 'integer', 'exists:transfers,id']
        ];
    }

    public function messages(): array
    {
        return [
            'transfer_id.required' => 'O ID da transferência é obrigatório.',
            'transfer_id.integer' => 'O ID da transferência deve ser um número inteiro.',
            'transfer_id.exists' => 'A transferência informada não existe.',
        ];
    }
}
