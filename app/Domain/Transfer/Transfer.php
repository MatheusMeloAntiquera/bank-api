<?php

namespace App\Domain\Transfer;

use App\Domain\User\User;
use App\Domain\Transaction\Transaction;


class Transfer extends Transaction
{
    public string|int|null $id;
    public string|int $senderId;
    public string|int $recipientId;
    public float $value;
    public float $senderBalance;
    public float $recipientBalance;
    public ?string $createdAt;
    public ?string $updatedAt;

    public function __construct(
        string|int $senderId,
        string|int $recipientId,
        float $value,
        float $senderBalance,
        float $recipientBalance,
        $id = null,
        $createdAt = null,
        $updatedAt = null
    ) {
        $this->id = $id;
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->value = $value;
        $this->senderBalance = $senderBalance;
        $this->recipientBalance = $recipientBalance;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
