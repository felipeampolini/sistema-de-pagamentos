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

    /**
     * @OA\Post(
     *     path="/api/v1/transfer/reverse",
     *     summary="Estornar transferência",
     *     tags={"Transferências"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"transfer_id"},
     *             @OA\Property(property="transfer_id", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Transferência estornada"),
     *     @OA\Response(response=422, description="Não foi possível estornar")
     * )
     */
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
