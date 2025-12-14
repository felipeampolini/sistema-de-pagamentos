<?php

namespace App\Repositories;

use App\Models\Transfer;
use Illuminate\Database\Eloquent\Collection;

class TransferRepository
{
    /**
     * Busca uma transferência pelo ID.
     */
    public function find(int $id): ?Transfer
    {
        return Transfer::find($id);
    }

    /**
     * Salva ou atualiza uma transferência.
     */
    public function save(Transfer $transfer): Transfer
    {
        $transfer->save();
        return $transfer;
    }

    /**
     * Cria uma nova transferência.
     */
    public function create(array $data): Transfer
    {
        return Transfer::create($data);
    }

    /**
     * Lista todas as transferências de um usuário (enviadas ou recebidas).
     */
    public function getByUserId(int $userId): Collection
    {
        return Transfer::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->get();
    }

    /**
     * Lista transferências por status.
     */
    public function getByStatus(string $status): Collection
    {
        return Transfer::where('status', $status)->get();
    }

    /**
     * Lista transferências recebidas por um usuário.
     */
    public function getReceivedByUserId(int $userId): Collection
    {
        return Transfer::where('receiver_id', $userId)->get();
    }

    /**
     * Lista transferências enviadas por um usuário.
     */
    public function getSentByUserId(int $userId): Collection
    {
        return Transfer::where('sender_id', $userId)->get();
    }
}
