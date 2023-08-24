<?php

namespace App\Domain\Transaction;

abstract class DtoTransactionCreate
{
    public int|string $senderId;
    public int|string $recipientId;
    public float $value;
    public function __construct(int|string $senderId, int|string $recipientId, float $value)
    {
        $this->senderId = $senderId;
        $this->recipientId = $recipientId;
        $this->value = $value;
    }
}
