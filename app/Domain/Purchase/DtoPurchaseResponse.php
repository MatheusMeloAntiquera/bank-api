<?php

namespace App\Domain\Purchase;

use App\Domain\Purchase\Purchase;


class DtoPurchaseResponse
{
    public static function toArray(Purchase $transaction): array
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
