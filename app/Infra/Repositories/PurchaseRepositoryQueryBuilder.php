<?php

namespace App\Infra\Repositories;

use App\Domain\User\User;
use App\Domain\Purchase\Purchase;
use Illuminate\Support\Facades\DB;
use App\Domain\Transaction\Recipient;
use App\Domain\Transaction\TransactionRepositoryInterface;


class PurchaseRepositoryQueryBuilder implements TransactionRepositoryInterface
{
    private string $table = "purchases";

    public function registerNewTransaction(User $sender, Recipient $recipient, float $value): Purchase
    {

        $createdAt = now();
        $purchaseId = DB::table($this->table)->insertGetId([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
            'sender_balance' => $sender->balance,
            'recipient_balance' => $recipient->balance,
            'value' => $value,
            'created_at' => $createdAt,
        ]);

        return new Purchase(
            id: $purchaseId,
            senderId: $sender->id,
            recipientId: $recipient->id,
            senderBalance: $sender->balance,
            recipientBalance: $recipient->balance,
            value: $value,
            createdAt: $createdAt,
        );
    }
}
