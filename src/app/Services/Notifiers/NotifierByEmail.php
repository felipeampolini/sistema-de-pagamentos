<?php

namespace App\Services\Notifiers;

use App\Models\User;
use App\Services\Notifiers\NotifierInterface;
use Exception;

class NotifierByEmail implements NotifierInterface
{
    public function notify(int $targetId, string $message): bool
    {

        try {

            $user = User::find($targetId);

            // Uso o email do target e a mensagem para fazer o envio do email

            return true;
        } catch (Exception $e) {
            logger()->error("Erro ao enviar email para {$user->email}: {$e->getMessage()}");
            return false;
        }

    }
}
