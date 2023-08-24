<?php

namespace App\Domain\Transaction;

use App\Domain\Transaction\DtoTransactionExecute;

interface TransactionServiceInterface
{
    public function execute(DtoTransactionExecute $dtoCreate);
}
