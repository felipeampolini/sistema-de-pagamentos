<?php

namespace App\Http\Controllers\V1\Transfer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transfer\TransferRequest;
use App\DTO\Transfer\TransferDTO;
use App\Services\Transfer\TransferService;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class TransferController extends Controller
{
    private TransferService $service;

    public function __construct(TransferService $service)
    {
        $this->service = $service;
    }

    public function __invoke(TransferRequest $request): JsonResponse
    {
        $user = JWTAuth::parseToken()->authenticate();

        $dto = new TransferDTO(array_merge(
            $request->validated(),
            ['sender_id' => $user->id]
        ));

        $transfer = $this->service->execute($dto);

        return response()->json([
            'id' => $transfer->id,
            'sender_id' => $transfer->sender_id,
            'receiver_id' => $transfer->receiver_id,
            'amount' => $transfer->amount,
            'status' => $transfer->status,
            'created_at' => $transfer->created_at,
        ]);
    }
}
