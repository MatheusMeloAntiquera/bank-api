<?php

namespace App\Domain\Transfer;

use App\Domain\Transfer\Transfer;


class DtoTransferResponse
{
    public static function toArray(Transfer $transaction): array
    {
        return [
            "id" => $transaction->id,
            "sender_id" => $transaction->senderId,
            "recipient_id" => $transaction->recipientId,
            "value" => $transaction->value,
            "sender_balance" => $transaction->senderBalance,
            "recipient_balance" => $transaction->recipientBalance,
            "created_at" => $transaction->createdAt,
            "updated_at" => $transaction->updatedAt,
        ];
    }
}
