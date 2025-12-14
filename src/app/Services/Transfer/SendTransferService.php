<?php

namespace App\Services\Transfer;

use App\DTO\Transfer\SendTransferDTO;
use App\Actions\Transfer\SendTransferAction;
use App\Models\Transfer;
use App\Services\Authorizers\AuthorizerByEmail;
use App\Services\Notifiers\NotifierByEmail;
use App\Validators\Transfer\SendTransferValidator;

class SendTransferService
{

    public function execute(SendTransferDTO $dto): Transfer
    {
        // Como estou usando interface, preciso declarar antes para fazer DI dentro da action.
        // OBS: O laravel nao consegue entender sozinho oque precisa fazer, por isso faço dessa maneira diferente aqui.
        $authorizer = new AuthorizerByEmail(); // ou AuthorizerByApp()
        $notifier = new NotifierByEmail(); // ou NotifierBySMS()
        $validator = new SendTransferValidator();
        $action = new SendTransferAction($authorizer, $notifier, $validator);
        return $action->execute($dto);
    }
}
