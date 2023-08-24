<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain\Purchase\DtoPurchaseExecute;
use App\Domain\Purchase\DtoPurchaseResponse;
use App\Domain\Transaction\TransactionServiceInterface;

class PurchaseController extends Controller
{
    private TransactionServiceInterface $transactionService;
    public function __construct(TransactionServiceInterface $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function executePurchase(Request $request)
    {
        $transaction = $this->transactionService->execute(
            new DtoPurchaseExecute(
                $request->sender_id,
                $request->recipient_id,
                $request->value
            )
        );

        return response()->json(
            DtoPurchaseResponse::toArray($transaction),
            201
        );
    }
}
