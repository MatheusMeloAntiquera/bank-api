<?php

namespace App\Infra\Repositories;

use Exception;
use Illuminate\Support\Facades\Http;
use App\Domain\Transaction\Recipient;
use App\Domain\Transaction\Transaction;

class NotifyServiceRepository
{
    private $url = "http://o4d9z.mocklab.io/notify";
    public function sendMessageToRecipient(Recipient $recipient, Transaction $transaction): bool
    {
        try {
            $response = Http::withOptions(['verify' => false, 'http_errors' => false, "timeout" => 2.0])->post($this->url, ["recipient_id" => $recipient->id, "transaction_id" => $transaction->id]);
            return $response->status() == 200;
        } catch (Exception $e) {
            return false;
        }
    }
}
