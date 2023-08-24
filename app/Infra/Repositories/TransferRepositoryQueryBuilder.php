<?php

namespace App\Infra\Repositories;

use App\Domain\User\User;
use App\Domain\Transfer\Transfer;
use Illuminate\Support\Facades\DB;
use App\Domain\Transaction\Recipient;
use App\Domain\Transaction\TransactionRepositoryInterface;


class TransferRepositoryQueryBuilder implements TransactionRepositoryInterface
{
    private string $table = "transfers";

    public function registerNewTransaction(User $sender, Recipient $recipient, float $value): Transfer
    {

        $createdAt = now();
        $transferId = DB::table($this->table)->insertGetId([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
            'sender_balance' => $sender->balance,
            'recipient_balance' => $recipient->balance,
            'value' => $value,
            'created_at' => $createdAt,
        ]);

        return new Transfer(
            id: $transferId,
            senderId: $sender->id,
            recipientId: $recipient->id,
            senderBalance: $sender->balance,
            recipientBalance: $recipient->balance,
            value: $value,
            createdAt: $createdAt,
        );
    }
}
