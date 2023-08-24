<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Transfer\DtoTransferExecute;
use App\Domain\Transfer\DtoTransferResponse;
use App\Domain\Transaction\TransactionServiceInterface;

class TransferController extends Controller
{
    private TransactionServiceInterface $transactionService;
    public function __construct(TransactionServiceInterface $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function executeTransfer(Request $request){
        $transaction = $this->transactionService->execute(
            new DtoTransferExecute(
                $request->sender_id,
                $request->recipient_id,
                $request->value
            )
        );

        return response()->json(
            DtoTransferResponse::toArray($transaction),
            201
        );
    }
}
