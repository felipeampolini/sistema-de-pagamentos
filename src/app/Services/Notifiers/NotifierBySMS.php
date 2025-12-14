<?php

namespace App\Services\Notifiers;

use App\Models\User;
use App\Services\Notifiers\NotifierInterface;
use Exception;

class NotifierBySms implements NotifierInterface
{
    public function notify(int $targetId, string $message): bool
    {

        try {

            $user = User::find($targetId);

            // Uso o telefone do target e a mensagem para fazer o envio do SMS

            return true;
        } catch (Exception $e) {
            logger()->error("Erro ao enviar SMS para {$user->phone}: {$e->getMessage()}");
            return false;
        }

    }
}
