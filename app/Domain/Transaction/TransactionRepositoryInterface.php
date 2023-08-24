<?php

namespace App\Domain\Transaction;

use App\Domain\User\User;
use App\Domain\Store\Store;
use App\Domain\Transaction\Recipient;
use App\Domain\Transaction\Transaction;


interface TransactionRepositoryInterface
{
    public function registerNewTransaction(User $sender, Recipient $recipient, float $value): Transaction;

}
