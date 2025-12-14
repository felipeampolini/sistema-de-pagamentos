<?php

namespace App\Http\Controllers\V1\Transfer;

use App\DTO\Transfer\ReverseTransferDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transfer\ReverseTransferRequest;
use App\Services\Transfer\ReverseTransferService;
use Illuminate\Http\JsonResponse;

class ReverseTransferController extends Controller
{
    private ReverseTransferService $service;

    public function __construct(ReverseTransferService $service)
    {
        $this->service = $service;
    }

    public function __invoke(ReverseTransferRequest $request): JsonResponse
    {
        $dto = new ReverseTransferDTO($request->transfer_id, $request->user()->id);

        $transfer = $this->service->execute($dto);

        return response()->json([
            'message' => 'Transferência estornada com sucesso.',
            'transfer' => $transfer,
        ], 200);
    }
}
