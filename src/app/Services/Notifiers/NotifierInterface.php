<?php

namespace App\Services\Notifiers;

interface NotifierInterface
{
    public function notify(int $targetId, string $message): bool;
}
