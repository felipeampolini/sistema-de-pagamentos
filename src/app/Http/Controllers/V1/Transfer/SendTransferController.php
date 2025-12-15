<?php

namespace App\Http\Controllers\V1\Transfer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transfer\SendTransferRequest;
use App\DTO\Transfer\SendTransferDTO;
use App\Services\Transfer\SendTransferService;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class SendTransferController extends Controller
{
    private SendTransferService $service;

    public function __construct(SendTransferService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/transfer/send",
     *     summary="Enviar transferência",
     *     tags={"Transferências"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"receiver_id","amount"},
     *             @OA\Property(property="receiver_id", type="integer", example=2),
     *             @OA\Property(property="amount", type="number", example=75.00)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Transferência realizada"),
     *     @OA\Response(response=422, description="Erro na transferência")
     * )
     */
    public function __invoke(SendTransferRequest $request): JsonResponse
    {
        $user = JWTAuth::parseToken()->authenticate();

        $dto = new SendTransferDTO(array_merge(
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
