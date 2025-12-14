<?php

namespace App\Services\Transfer\Authorizers;

use App\Services\Authorizers\AuthorizerInterface;

class AuthorizerByApp implements AuthorizerInterface
{
    public function authorize(float $amount, int $senderId, int $receiverId): bool
    {
        // Lógica de autorização via APP
        // envia notificacao para o app
        // aguarda retorno por x tempo.

        // Outra opcao seria tornar a transferencia como pending. e o método de confirmacao do app, chama o metodo que completa a transacao.
        return true;
    }
}
