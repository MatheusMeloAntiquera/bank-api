<?php

namespace App\Infra\Repositories;

use Illuminate\Support\Facades\Http;

class AuthorizationServiceRepository
{
    public function isAuthorized(): bool
    {
        $response = Http::withOptions([
            'verify' => false
        ])->retry(
            3,
            500,
            null,
            false
        )->get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');

        return $response->status() == 200;
    }
}
