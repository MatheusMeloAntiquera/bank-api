<?php

namespace App\Domain\Transaction;

use App\Domain\Transfer\DtoTransferCreate;

interface TransactionServiceInterface
{
    public function execute(DtoTransferCreate $dtoCreate);
}
