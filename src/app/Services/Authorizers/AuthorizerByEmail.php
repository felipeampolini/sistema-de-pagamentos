<?php

namespace App\Services\Authorizers;

use App\Services\Authorizers\AuthorizerInterface;

class AuthorizerByEmail implements AuthorizerInterface
{
    public function authorize(float $amount, int $senderId, int $receiverId): bool
    {
        // Lógica de autorização via email
        // envia email
        // aguarda retorno por x tempo.

        // Outra opcao seria tornar a transferencia como pending. e o método de confirmacao do email, chama o metodo que completa a transacao.
        return true;
    }
}
