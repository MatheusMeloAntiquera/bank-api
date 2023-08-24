<?php

namespace App\Infra\Services;

use App\Domain\User\User;
use Illuminate\Support\Facades\DB;
use App\Exceptions\NotFoundException;

class TransferService extends TransactionServiceBase
{
    protected function setSender(int|string $id): void
    {
        $sender = $this->userRepository->findUser($id);

        if ($sender === null) {
            throw new NotFoundException("Sender not found");
        }
        $this->sender = $sender;
    }

    protected function setRecipient(int|string $id): void
    {
        $recipient = $this->userRepository->findUser($id);

        if ($recipient === null) {
            throw new NotFoundException("Recipient not found");
        }
        $this->recipient = $recipient;
    }

    protected function updateBalances(float $value): void
    {
        $this->userRepository->updateBalance($this->sender, $this->sender->balance - $value);
        $this->userRepository->updateBalance($this->recipient, $this->recipient->balance + $value);
    }

    protected function startTransaction(): void
    {
        DB::beginTransaction();
    }

    protected function rollbackTransaction(): void
    {
        DB::rollBack();
    }
}
